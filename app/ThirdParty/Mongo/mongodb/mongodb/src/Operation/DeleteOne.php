<?php

namespace MongoDB\Operation;

use MongoDB\DeleteResult;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnsupportedException;

class DeleteOne implements Executable, Explainable
{
    private $delete;

    public function __construct(string $databaseName, string $collectionName, $filter, array $options = [])
    {
        $this->delete = new Delete($databaseName, $collectionName, $filter, 1, $options);
    }

    public function execute(Server $server)
    {
        return $this->delete->execute($server);
    }

    public function getCommandDocument(Server $server)
    {
        return $this->delete->getCommandDocument($server);
    }
}