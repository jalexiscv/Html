<?php

namespace MongoDB\Operation;

use MongoDB\BSON\TimestampInterface;
use MongoDB\ChangeStream;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Exception\RuntimeException;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Monitoring\CommandFailedEvent;
use MongoDB\Driver\Monitoring\CommandStartedEvent;
use MongoDB\Driver\Monitoring\CommandSubscriber;
use MongoDB\Driver\Monitoring\CommandSucceededEvent;
use MongoDB\Driver\ReadPreference;
use MongoDB\Driver\Server;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnexpectedValueException;
use MongoDB\Exception\UnsupportedException;
use MongoDB\Model\ChangeStreamIterator;
use function array_intersect_key;
use function array_key_exists;
use function array_unshift;
use function assert;
use function count;
use function is_array;
use function is_bool;
use function is_object;
use function is_string;
use function MongoDB\Driver\Monitoring\addSubscriber;
use function MongoDB\Driver\Monitoring\removeSubscriber;
use function MongoDB\select_server;
use function MongoDB\server_supports_feature;

class Watch implements Executable, CommandSubscriber
{
    public const FULL_DOCUMENT_DEFAULT = 'default';
    public const FULL_DOCUMENT_UPDATE_LOOKUP = 'updateLookup';
    public const FULL_DOCUMENT_WHEN_AVAILABLE = 'whenAvailable';
    public const FULL_DOCUMENT_REQUIRED = 'required';
    public const FULL_DOCUMENT_BEFORE_CHANGE_OFF = 'off';
    public const FULL_DOCUMENT_BEFORE_CHANGE_WHEN_AVAILABLE = 'whenAvailable';
    public const FULL_DOCUMENT_BEFORE_CHANGE_REQUIRED = 'required';
    private static $wireVersionForStartAtOperationTime = 7;
    private $aggregate;
    private $aggregateOptions;
    private $changeStreamOptions;
    private $collectionName;
    private $databaseName;
    private $firstBatchSize;
    private $hasResumed = false;
    private $manager;
    private $operationTime;
    private $pipeline;
    private $postBatchResumeToken;

    public function __construct(Manager $manager, ?string $databaseName, ?string $collectionName, array $pipeline, array $options = [])
    {
        if (isset($collectionName) && !isset($databaseName)) {
            throw new InvalidArgumentException('$collectionName should also be null if $databaseName is null');
        }
        $options += ['readPreference' => new ReadPreference(ReadPreference::RP_PRIMARY),];
        if (array_key_exists('fullDocument', $options) && !is_string($options['fullDocument'])) {
            throw InvalidArgumentException::invalidType('"fullDocument" option', $options['fullDocument'], 'string');
        }
        if (isset($options['fullDocumentBeforeChange']) && !is_string($options['fullDocumentBeforeChange'])) {
            throw InvalidArgumentException::invalidType('"fullDocumentBeforeChange" option', $options['fullDocumentBeforeChange'], 'string');
        }
        if (!$options['readPreference'] instanceof ReadPreference) {
            throw InvalidArgumentException::invalidType('"readPreference" option', $options['readPreference'], ReadPreference::class);
        }
        if (isset($options['resumeAfter']) && !is_array($options['resumeAfter']) && !is_object($options['resumeAfter'])) {
            throw InvalidArgumentException::invalidType('"resumeAfter" option', $options['resumeAfter'], 'array or object');
        }
        if (isset($options['startAfter']) && !is_array($options['startAfter']) && !is_object($options['startAfter'])) {
            throw InvalidArgumentException::invalidType('"startAfter" option', $options['startAfter'], 'array or object');
        }
        if (isset($options['startAtOperationTime']) && !$options['startAtOperationTime'] instanceof TimestampInterface) {
            throw InvalidArgumentException::invalidType('"startAtOperationTime" option', $options['startAtOperationTime'], TimestampInterface::class);
        }
        if (isset($options['showExpandedEvents']) && !is_bool($options['showExpandedEvents'])) {
            throw InvalidArgumentException::invalidType('"showExpandedEvents" option', $options['showExpandedEvents'], 'bool');
        }
        if (!isset($options['session'])) {
            try {
                $options['session'] = $manager->startSession(['causalConsistency' => false]);
            } catch (RuntimeException $e) {
            }
        }
        $this->aggregateOptions = array_intersect_key($options, ['batchSize' => 1, 'collation' => 1, 'comment' => 1, 'maxAwaitTimeMS' => 1, 'readConcern' => 1, 'readPreference' => 1, 'session' => 1, 'typeMap' => 1]);
        $this->changeStreamOptions = array_intersect_key($options, ['fullDocument' => 1, 'fullDocumentBeforeChange' => 1, 'resumeAfter' => 1, 'showExpandedEvents' => 1, 'startAfter' => 1, 'startAtOperationTime' => 1]);
        if ($databaseName === null) {
            $databaseName = 'admin';
            $this->changeStreamOptions['allChangesForCluster'] = true;
        }
        $this->manager = $manager;
        $this->databaseName = $databaseName;
        $this->collectionName = $collectionName;
        $this->pipeline = $pipeline;
        $this->aggregate = $this->createAggregate();
    }

    final public function commandFailed(CommandFailedEvent $event): void
    {
    }

    final public function commandStarted(CommandStartedEvent $event): void
    {
        if ($event->getCommandName() !== 'aggregate') {
            return;
        }
        $this->firstBatchSize = 0;
        $this->postBatchResumeToken = null;
    }

    final public function commandSucceeded(CommandSucceededEvent $event): void
    {
        if ($event->getCommandName() !== 'aggregate') {
            return;
        }
        $reply = $event->getReply();
        if (!isset($reply->cursor->firstBatch) || !is_array($reply->cursor->firstBatch)) {
            throw new UnexpectedValueException('aggregate command did not return a "cursor.firstBatch" array');
        }
        $this->firstBatchSize = count($reply->cursor->firstBatch);
        if (isset($reply->cursor->postBatchResumeToken) && is_object($reply->cursor->postBatchResumeToken)) {
            $this->postBatchResumeToken = $reply->cursor->postBatchResumeToken;
        }
        if ($this->shouldCaptureOperationTime($event->getServer()) && isset($reply->operationTime) && $reply->operationTime instanceof TimestampInterface) {
            $this->operationTime = $reply->operationTime;
        }
    }

    public function execute(Server $server)
    {
        return new ChangeStream($this->createChangeStreamIterator($server), function ($resumeToken, $hasAdvanced): ChangeStreamIterator {
            return $this->resume($resumeToken, $hasAdvanced);
        });
    }

    private function createAggregate(): Aggregate
    {
        $pipeline = $this->pipeline;
        array_unshift($pipeline, ['$changeStream' => (object)$this->changeStreamOptions]);
        return new Aggregate($this->databaseName, $this->collectionName, $pipeline, $this->aggregateOptions);
    }

    private function createChangeStreamIterator(Server $server): ChangeStreamIterator
    {
        return new ChangeStreamIterator($this->executeAggregate($server), $this->firstBatchSize, $this->getInitialResumeToken(), $this->postBatchResumeToken);
    }

    private function executeAggregate(Server $server): Cursor
    {
        addSubscriber($this);
        try {
            $cursor = $this->aggregate->execute($server);
            assert($cursor instanceof Cursor);
            return $cursor;
        } finally {
            removeSubscriber($this);
        }
    }

    private function getInitialResumeToken()
    {
        if ($this->firstBatchSize === 0 && isset($this->postBatchResumeToken)) {
            return $this->postBatchResumeToken;
        }
        if (isset($this->changeStreamOptions['startAfter'])) {
            return $this->changeStreamOptions['startAfter'];
        }
        if (isset($this->changeStreamOptions['resumeAfter'])) {
            return $this->changeStreamOptions['resumeAfter'];
        }
        return null;
    }

    private function resume($resumeToken = null, bool $hasAdvanced = false): ChangeStreamIterator
    {
        if (isset($resumeToken) && !is_array($resumeToken) && !is_object($resumeToken)) {
            throw InvalidArgumentException::invalidType('$resumeToken', $resumeToken, 'array or object');
        }
        $this->hasResumed = true;
        $server = select_server($this->manager, $this->aggregateOptions);
        $resumeOption = isset($this->changeStreamOptions['startAfter']) && !$hasAdvanced ? 'startAfter' : 'resumeAfter';
        unset($this->changeStreamOptions['resumeAfter']);
        unset($this->changeStreamOptions['startAfter']);
        unset($this->changeStreamOptions['startAtOperationTime']);
        if ($resumeToken !== null) {
            $this->changeStreamOptions[$resumeOption] = $resumeToken;
        }
        if ($resumeToken === null && $this->operationTime !== null) {
            $this->changeStreamOptions['startAtOperationTime'] = $this->operationTime;
        }
        $this->aggregate = $this->createAggregate();
        return $this->createChangeStreamIterator($server);
    }

    private function shouldCaptureOperationTime(Server $server): bool
    {
        if ($this->hasResumed) {
            return false;
        }
        if (isset($this->changeStreamOptions['resumeAfter']) || isset($this->changeStreamOptions['startAfter']) || isset($this->changeStreamOptions['startAtOperationTime'])) {
            return false;
        }
        if ($this->firstBatchSize > 0) {
            return false;
        }
        if ($this->postBatchResumeToken !== null) {
            return false;
        }
        if (!server_supports_feature($server, self::$wireVersionForStartAtOperationTime)) {
            return false;
        }
        return true;
    }
}