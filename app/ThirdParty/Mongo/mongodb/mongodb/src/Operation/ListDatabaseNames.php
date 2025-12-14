<?php

namespace MongoDB\Operation;

use ArrayIterator;
use Iterator;
use MongoDB\Command\ListDatabases as ListDatabasesCommand;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnexpectedValueException;
use function array_column;

class ListDatabaseNames implements Executable
{
    private $listDatabases;

    public function __construct(array $options = [])
    {
        $this->listDatabases = new ListDatabasesCommand(['nameOnly' => true] + $options);
    }

    public function execute(Server $server): Iterator
    {
        $result = $this->listDatabases->execute($server);
        return new ArrayIterator(array_column($result, 'name'));
    }
}