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

class ReplaceOne implements Executable
{
    private $update;

    public function __construct(string $databaseName, string $collectionName, $filter, $replacement, array $options = [])
    {
        if (!is_array($replacement) && !is_object($replacement)) {
            throw InvalidArgumentException::invalidType('$replacement', $replacement, 'array or object');
        }
        if (is_first_key_operator($replacement)) {
            throw new InvalidArgumentException('First key in $replacement argument is an update operator');
        }
        if (is_pipeline($replacement)) {
            throw new InvalidArgumentException('$replacement argument is a pipeline');
        }
        $this->update = new Update($databaseName, $collectionName, $filter, $replacement, ['multi' => false] + $options);
    }

    public function execute(Server $server)
    {
        return $this->update->execute($server);
    }
}