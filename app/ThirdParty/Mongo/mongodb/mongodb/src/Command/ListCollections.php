<?php

namespace MongoDB\Command;

use MongoDB\Driver\Command;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Driver\Session;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Model\CachingIterator;
use MongoDB\Operation\Executable;
use function is_array;
use function is_bool;
use function is_integer;
use function is_object;

class ListCollections implements Executable
{
    private $databaseName;
    private $options;

    public function __construct(string $databaseName, array $options = [])
    {
        if (isset($options['authorizedCollections']) && !is_bool($options['authorizedCollections'])) {
            throw InvalidArgumentException::invalidType('"authorizedCollections" option', $options['authorizedCollections'], 'boolean');
        }
        if (isset($options['filter']) && !is_array($options['filter']) && !is_object($options['filter'])) {
            throw InvalidArgumentException::invalidType('"filter" option', $options['filter'], 'array or object');
        }
        if (isset($options['maxTimeMS']) && !is_integer($options['maxTimeMS'])) {
            throw InvalidArgumentException::invalidType('"maxTimeMS" option', $options['maxTimeMS'], 'integer');
        }
        if (isset($options['nameOnly']) && !is_bool($options['nameOnly'])) {
            throw InvalidArgumentException::invalidType('"nameOnly" option', $options['nameOnly'], 'boolean');
        }
        if (isset($options['session']) && !$options['session'] instanceof Session) {
            throw InvalidArgumentException::invalidType('"session" option', $options['session'], Session::class);
        }
        $this->databaseName = $databaseName;
        $this->options = $options;
    }

    public function execute(Server $server): CachingIterator
    {
        $cursor = $server->executeReadCommand($this->databaseName, $this->createCommand(), $this->createOptions());
        $cursor->setTypeMap(['root' => 'array', 'document' => 'array']);
        return new CachingIterator($cursor);
    }

    private function createCommand(): Command
    {
        $cmd = ['listCollections' => 1];
        if (!empty($this->options['filter'])) {
            $cmd['filter'] = (object)$this->options['filter'];
        }
        foreach (['authorizedCollections', 'comment', 'maxTimeMS', 'nameOnly'] as $option) {
            if (isset($this->options[$option])) {
                $cmd[$option] = $this->options[$option];
            }
        }
        return new Command($cmd);
    }

    private function createOptions(): array
    {
        $options = [];
        if (isset($this->options['session'])) {
            $options['session'] = $this->options['session'];
        }
        return $options;
    }
}