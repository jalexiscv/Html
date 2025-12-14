<?php

namespace MongoDB\Operation;

use Iterator;
use MongoDB\Command\ListCollections as ListCollectionsCommand;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Model\CallbackIterator;

class ListCollectionNames implements Executable
{
    private $listCollections;

    public function __construct(string $databaseName, array $options = [])
    {
        $this->listCollections = new ListCollectionsCommand($databaseName, ['nameOnly' => true] + $options);
    }

    public function execute(Server $server): Iterator
    {
        return new CallbackIterator($this->listCollections->execute($server), function (array $collectionInfo) {
            return $collectionInfo['name'];
        });
    }
}