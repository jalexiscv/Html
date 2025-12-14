<?php

namespace MongoDB\Operation;

use MongoDB\Driver\Command;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Driver\Session;
use MongoDB\Driver\WriteConcern;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnsupportedException;
use MongoDB\Model\IndexInput;
use function array_map;
use function is_array;
use function is_integer;
use function is_string;
use function MongoDB\server_supports_feature;
use function sprintf;

class CreateIndexes implements Executable
{
    private static $wireVersionForCommitQuorum = 9;
    private $databaseName;
    private $collectionName;
    private $indexes = [];
    private $options = [];

    public function __construct(string $databaseName, string $collectionName, array $indexes, array $options = [])
    {
        if (empty($indexes)) {
            throw new InvalidArgumentException('$indexes is empty');
        }
        $expectedIndex = 0;
        foreach ($indexes as $i => $index) {
            if ($i !== $expectedIndex) {
                throw new InvalidArgumentException(sprintf('$indexes is not a list (unexpected index: "%s")', $i));
            }
            if (!is_array($index)) {
                throw InvalidArgumentException::invalidType(sprintf('$index[%d]', $i), $index, 'array');
            }
            $this->indexes[] = new IndexInput($index);
            $expectedIndex += 1;
        }
        if (isset($options['commitQuorum']) && !is_string($options['commitQuorum']) && !is_integer($options['commitQuorum'])) {
            throw InvalidArgumentException::invalidType('"commitQuorum" option', $options['commitQuorum'], ['integer', 'string']);
        }
        if (isset($options['maxTimeMS']) && !is_integer($options['maxTimeMS'])) {
            throw InvalidArgumentException::invalidType('"maxTimeMS" option', $options['maxTimeMS'], 'integer');
        }
        if (isset($options['session']) && !$options['session'] instanceof Session) {
            throw InvalidArgumentException::invalidType('"session" option', $options['session'], Session::class);
        }
        if (isset($options['writeConcern']) && !$options['writeConcern'] instanceof WriteConcern) {
            throw InvalidArgumentException::invalidType('"writeConcern" option', $options['writeConcern'], WriteConcern::class);
        }
        if (isset($options['writeConcern']) && $options['writeConcern']->isDefault()) {
            unset($options['writeConcern']);
        }
        $this->databaseName = $databaseName;
        $this->collectionName = $collectionName;
        $this->options = $options;
    }

    public function execute(Server $server)
    {
        $inTransaction = isset($this->options['session']) && $this->options['session']->isInTransaction();
        if ($inTransaction && isset($this->options['writeConcern'])) {
            throw UnsupportedException::writeConcernNotSupportedInTransaction();
        }
        $this->executeCommand($server);
        return array_map(function (IndexInput $index) {
            return (string)$index;
        }, $this->indexes);
    }

    private function createOptions(): array
    {
        $options = [];
        if (isset($this->options['session'])) {
            $options['session'] = $this->options['session'];
        }
        if (isset($this->options['writeConcern'])) {
            $options['writeConcern'] = $this->options['writeConcern'];
        }
        return $options;
    }

    private function executeCommand(Server $server): void
    {
        $cmd = ['createIndexes' => $this->collectionName, 'indexes' => $this->indexes,];
        if (isset($this->options['commitQuorum'])) {
            if (!server_supports_feature($server, self::$wireVersionForCommitQuorum)) {
                throw UnsupportedException::commitQuorumNotSupported();
            }
            $cmd['commitQuorum'] = $this->options['commitQuorum'];
        }
        foreach (['comment', 'maxTimeMS'] as $option) {
            if (isset($this->options[$option])) {
                $cmd[$option] = $this->options[$option];
            }
        }
        $server->executeWriteCommand($this->databaseName, new Command($cmd), $this->createOptions());
    }
}