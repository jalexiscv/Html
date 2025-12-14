<?php

namespace MongoDB\Operation;

use MongoDB\Command\ListDatabases as ListDatabasesCommand;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnexpectedValueException;
use MongoDB\Model\DatabaseInfoIterator;
use MongoDB\Model\DatabaseInfoLegacyIterator;

class ListDatabases implements Executable
{
    private $listDatabases;

    public function __construct(array $options = [])
    {
        $this->listDatabases = new ListDatabasesCommand(['nameOnly' => false] + $options);
    }

    public function execute(Server $server)
    {
        return new DatabaseInfoLegacyIterator($this->listDatabases->execute($server));
    }
}