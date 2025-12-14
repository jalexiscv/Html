<?php

namespace MongoDB\Operation;

use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnsupportedException;
use function is_array;
use function is_object;

class FindOneAndDelete implements Executable, Explainable
{
    private $findAndModify;

    public function __construct(string $databaseName, string $collectionName, $filter, array $options = [])
    {
        if (!is_array($filter) && !is_object($filter)) {
            throw InvalidArgumentException::invalidType('$filter', $filter, 'array or object');
        }
        if (isset($options['projection']) && !is_array($options['projection']) && !is_object($options['projection'])) {
            throw InvalidArgumentException::invalidType('"projection" option', $options['projection'], 'array or object');
        }
        if (isset($options['projection'])) {
            $options['fields'] = $options['projection'];
        }
        unset($options['projection']);
        $this->findAndModify = new FindAndModify($databaseName, $collectionName, ['query' => $filter, 'remove' => true] + $options);
    }

    public function execute(Server $server)
    {
        return $this->findAndModify->execute($server);
    }

    public function getCommandDocument(Server $server)
    {
        return $this->findAndModify->getCommandDocument($server);
    }
}