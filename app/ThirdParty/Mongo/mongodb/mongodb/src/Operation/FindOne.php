<?php

namespace MongoDB\Operation;

use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnsupportedException;
use function current;

class FindOne implements Executable, Explainable
{
    private $find;

    public function __construct(string $databaseName, string $collectionName, $filter, array $options = [])
    {
        $this->find = new Find($databaseName, $collectionName, $filter, ['limit' => 1] + $options);
    }

    public function execute(Server $server)
    {
        $cursor = $this->find->execute($server);
        $document = current($cursor->toArray());
        return $document === false ? null : $document;
    }

    public function getCommandDocument(Server $server)
    {
        return $this->find->getCommandDocument($server);
    }
}