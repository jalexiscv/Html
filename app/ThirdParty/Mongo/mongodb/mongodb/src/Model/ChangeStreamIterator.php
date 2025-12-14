<?php

namespace MongoDB\Model;

use IteratorIterator;
use MongoDB\BSON\Serializable;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Monitoring\CommandFailedEvent;
use MongoDB\Driver\Monitoring\CommandStartedEvent;
use MongoDB\Driver\Monitoring\CommandSubscriber;
use MongoDB\Driver\Monitoring\CommandSucceededEvent;
use MongoDB\Driver\Server;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\ResumeTokenException;
use MongoDB\Exception\UnexpectedValueException;
use ReturnTypeWillChange;
use function assert;
use function count;
use function is_array;
use function is_object;
use function MongoDB\Driver\Monitoring\addSubscriber;
use function MongoDB\Driver\Monitoring\removeSubscriber;

class ChangeStreamIterator extends IteratorIterator implements CommandSubscriber
{
    private $batchPosition = 0;
    private $batchSize;
    private $isRewindNop;
    private $isValid = false;
    private $postBatchResumeToken;
    private $resumeToken;
    private $server;

    public function __construct(Cursor $cursor, int $firstBatchSize, $initialResumeToken, ?object $postBatchResumeToken)
    {
        if (isset($initialResumeToken) && !is_array($initialResumeToken) && !is_object($initialResumeToken)) {
            throw InvalidArgumentException::invalidType('$initialResumeToken', $initialResumeToken, 'array or object');
        }
        parent::__construct($cursor);
        $this->batchSize = $firstBatchSize;
        $this->isRewindNop = ($firstBatchSize === 0);
        $this->postBatchResumeToken = $postBatchResumeToken;
        $this->resumeToken = $initialResumeToken;
        $this->server = $cursor->getServer();
    }

    final public function commandFailed(CommandFailedEvent $event): void
    {
    }

    final public function commandStarted(CommandStartedEvent $event): void
    {
        if ($event->getCommandName() !== 'getMore') {
            return;
        }
        $this->batchPosition = 0;
        $this->batchSize = 0;
        $this->postBatchResumeToken = null;
    }

    final public function commandSucceeded(CommandSucceededEvent $event): void
    {
        if ($event->getCommandName() !== 'getMore') {
            return;
        }
        $reply = $event->getReply();
        if (!isset($reply->cursor->nextBatch) || !is_array($reply->cursor->nextBatch)) {
            throw new UnexpectedValueException('getMore command did not return a "cursor.nextBatch" array');
        }
        $this->batchSize = count($reply->cursor->nextBatch);
        if (isset($reply->cursor->postBatchResumeToken) && is_object($reply->cursor->postBatchResumeToken)) {
            $this->postBatchResumeToken = $reply->cursor->postBatchResumeToken;
        }
    }

    #[ReturnTypeWillChange] public function current()
    {
        return $this->isValid ? parent::current() : null;
    }

    final public function getInnerIterator(): Cursor
    {
        $cursor = parent::getInnerIterator();
        assert($cursor instanceof Cursor);
        return $cursor;
    }

    public function getResumeToken()
    {
        return $this->resumeToken;
    }

    public function getServer(): Server
    {
        return $this->server;
    }

    #[ReturnTypeWillChange] public function key()
    {
        return $this->isValid ? parent::key() : null;
    }

    public function next(): void
    {
        $getMore = $this->isAtEndOfBatch();
        if ($getMore) {
            addSubscriber($this);
        }
        try {
            parent::next();
            $this->onIteration(!$getMore);
        } finally {
            if ($getMore) {
                removeSubscriber($this);
            }
        }
    }

    public function rewind(): void
    {
        if ($this->isRewindNop) {
            return;
        }
        parent::rewind();
        $this->onIteration(false);
    }

    public function valid(): bool
    {
        return $this->isValid;
    }

    private function extractResumeToken($document)
    {
        if (!is_array($document) && !is_object($document)) {
            throw InvalidArgumentException::invalidType('$document', $document, 'array or object');
        }
        if ($document instanceof Serializable) {
            return $this->extractResumeToken($document->bsonSerialize());
        }
        $resumeToken = is_array($document) ? ($document['_id'] ?? null) : ($document->_id ?? null);
        if (!isset($resumeToken)) {
            $this->isValid = false;
            throw ResumeTokenException::notFound();
        }
        if (!is_array($resumeToken) && !is_object($resumeToken)) {
            $this->isValid = false;
            throw ResumeTokenException::invalidType($resumeToken);
        }
        return $resumeToken;
    }

    private function isAtEndOfBatch(): bool
    {
        return $this->batchPosition + 1 >= $this->batchSize;
    }

    private function onIteration(bool $incrementBatchPosition): void
    {
        $this->isValid = parent::valid();
        if ($this->isRewindNop && $this->isValid) {
            $this->isRewindNop = false;
        }
        if ($incrementBatchPosition && $this->isValid) {
            $this->batchPosition++;
        }
        if ($this->isAtEndOfBatch() && $this->postBatchResumeToken !== null) {
            $this->resumeToken = $this->postBatchResumeToken;
        } elseif ($this->isValid) {
            $this->resumeToken = $this->extractResumeToken($this->current());
        }
    }
}