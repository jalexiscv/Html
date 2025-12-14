<?php

namespace MongoDB\Command;

use MongoDB\Driver\Command;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Driver\Session;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnexpectedValueException;
use MongoDB\Operation\Executable;
use function current;
use function is_array;
use function is_bool;
use function is_integer;
use function is_object;

class ListDatabases implements Executable
{
    private $options;

    public function __construct(array $options = [])
    {
        if (isset($options['authorizedDatabases']) && !is_bool($options['authorizedDatabases'])) {
            throw InvalidArgumentException::invalidType('"authorizedDatabases" option', $options['authorizedDatabases'], 'boolean');
        }
        if (isset($options['filter']) && !is_array($options['filter']) && !is_object($options['filter'])) {
            throw InvalidArgumentException::invalidType('"filter" option', $options['filter'], ['array', 'object']);
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
        $this->options = $options;
    }

    public function execute(Server $server): array
    {
        $cursor = $server->executeReadCommand('admin', $this->createCommand(), $this->createOptions());
        $cursor->setTypeMap(['root' => 'array', 'document' => 'array']);
        $result = current($cursor->toArray());
        if (!isset($result['databases']) || !is_array($result['databases'])) {
            throw new UnexpectedValueException('listDatabases command did not return a "databases" array');
        }
        return $result['databases'];
    }

    private function createCommand(): Command
    {
        $cmd = ['listDatabases' => 1];
        if (!empty($this->options['filter'])) {
            $cmd['filter'] = (object)$this->options['filter'];
        }
        foreach (['authorizedDatabases', 'comment', 'maxTimeMS', 'nameOnly'] as $option) {
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