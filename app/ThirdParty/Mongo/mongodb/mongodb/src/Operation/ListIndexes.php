<?php

namespace MongoDB\Operation;

use EmptyIterator;
use MongoDB\Driver\Command;
use MongoDB\Driver\Exception\CommandException;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Driver\Session;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Model\CachingIterator;
use MongoDB\Model\IndexInfoIterator;
use MongoDB\Model\IndexInfoIteratorIterator;
use function is_integer;

class ListIndexes implements Executable
{
    private static $errorCodeDatabaseNotFound = 60;
    private static $errorCodeNamespaceNotFound = 26;
    private $databaseName;
    private $collectionName;
    private $options;

    public function __construct(string $databaseName, string $collectionName, array $options = [])
    {
        if (isset($options['maxTimeMS']) && !is_integer($options['maxTimeMS'])) {
            throw InvalidArgumentException::invalidType('"maxTimeMS" option', $options['maxTimeMS'], 'integer');
        }
        if (isset($options['session']) && !$options['session'] instanceof Session) {
            throw InvalidArgumentException::invalidType('"session" option', $options['session'], Session::class);
        }
        $this->databaseName = $databaseName;
        $this->collectionName = $collectionName;
        $this->options = $options;
    }

    public function execute(Server $server)
    {
        return $this->executeCommand($server);
    }

    private function createOptions(): array
    {
        $options = [];
        if (isset($this->options['session'])) {
            $options['session'] = $this->options['session'];
        }
        return $options;
    }

    private function executeCommand(Server $server): IndexInfoIteratorIterator
    {
        $cmd = ['listIndexes' => $this->collectionName];
        foreach (['comment', 'maxTimeMS'] as $option) {
            if (isset($this->options[$option])) {
                $cmd[$option] = $this->options[$option];
            }
        }
        try {
            $cursor = $server->executeReadCommand($this->databaseName, new Command($cmd), $this->createOptions());
        } catch (CommandException $e) {
            if ($e->getCode() === self::$errorCodeNamespaceNotFound || $e->getCode() === self::$errorCodeDatabaseNotFound) {
                return new IndexInfoIteratorIterator(new EmptyIterator());
            }
            throw $e;
        }
        $cursor->setTypeMap(['root' => 'array', 'document' => 'array']);
        return new IndexInfoIteratorIterator(new CachingIterator($cursor), $this->databaseName . '.' . $this->collectionName);
    }
}