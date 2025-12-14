<?php

namespace MongoDB\Operation;

use MongoDB\Command\ListCollections as ListCollectionsCommand;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Model\CollectionInfoCommandIterator;
use MongoDB\Model\CollectionInfoIterator;

class ListCollections implements Executable
{
    private $databaseName;
    private $listCollections;

    public function __construct(string $databaseName, array $options = [])
    {
        $this->databaseName = $databaseName;
        $this->listCollections = new ListCollectionsCommand($databaseName, ['nameOnly' => false] + $options);
    }

    public function execute(Server $server)
    {
        return new CollectionInfoCommandIterator($this->listCollections->execute($server), $this->databaseName);
    }
}