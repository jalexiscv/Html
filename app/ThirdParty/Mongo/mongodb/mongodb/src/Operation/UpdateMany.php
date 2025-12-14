<?php

namespace MongoDB\Operation;

use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnsupportedException;
use MongoDB\UpdateResult;
use function is_array;
use function is_object;
use function MongoDB\is_first_key_operator;
use function MongoDB\is_pipeline;

class UpdateMany implements Executable, Explainable
{
    private $update;

    public function __construct(string $databaseName, string $collectionName, $filter, $update, array $options = [])
    {
        if (!is_array($update) && !is_object($update)) {
            throw InvalidArgumentException::invalidType('$update', $update, 'array or object');
        }
        if (!is_first_key_operator($update) && !is_pipeline($update)) {
            throw new InvalidArgumentException('Expected an update document with operator as first key or a pipeline');
        }
        $this->update = new Update($databaseName, $collectionName, $filter, $update, ['multi' => true] + $options);
    }

    public function execute(Server $server)
    {
        return $this->update->execute($server);
    }

    public function getCommandDocument(Server $server)
    {
        return $this->update->getCommandDocument($server);
    }
}