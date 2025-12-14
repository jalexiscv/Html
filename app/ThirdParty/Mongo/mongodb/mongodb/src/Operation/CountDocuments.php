<?php

namespace MongoDB\Operation;

use MongoDB\Driver\Cursor;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnexpectedValueException;
use MongoDB\Exception\UnsupportedException;
use function array_intersect_key;
use function assert;
use function count;
use function current;
use function is_array;
use function is_float;
use function is_integer;
use function is_object;

class CountDocuments implements Executable
{
    private $databaseName;
    private $collectionName;
    private $filter;
    private $aggregateOptions;
    private $countOptions;
    private $aggregate;

    public function __construct(string $databaseName, string $collectionName, $filter, array $options = [])
    {
        if (!is_array($filter) && !is_object($filter)) {
            throw InvalidArgumentException::invalidType('$filter', $filter, 'array or object');
        }
        if (isset($options['limit']) && !is_integer($options['limit'])) {
            throw InvalidArgumentException::invalidType('"limit" option', $options['limit'], 'integer');
        }
        if (isset($options['skip']) && !is_integer($options['skip'])) {
            throw InvalidArgumentException::invalidType('"skip" option', $options['skip'], 'integer');
        }
        $this->databaseName = $databaseName;
        $this->collectionName = $collectionName;
        $this->filter = $filter;
        $this->aggregateOptions = array_intersect_key($options, ['collation' => 1, 'comment' => 1, 'hint' => 1, 'maxTimeMS' => 1, 'readConcern' => 1, 'readPreference' => 1, 'session' => 1]);
        $this->countOptions = array_intersect_key($options, ['limit' => 1, 'skip' => 1]);
        $this->aggregate = $this->createAggregate();
    }

    public function execute(Server $server)
    {
        $cursor = $this->aggregate->execute($server);
        assert($cursor instanceof Cursor);
        $allResults = $cursor->toArray();
        if (count($allResults) == 0) {
            return 0;
        }
        $result = current($allResults);
        if (!is_object($result) || !isset($result->n) || !(is_integer($result->n) || is_float($result->n))) {
            throw new UnexpectedValueException('count command did not return a numeric "n" value');
        }
        return (integer)$result->n;
    }

    private function createAggregate(): Aggregate
    {
        $pipeline = [['$match' => (object)$this->filter],];
        if (isset($this->countOptions['skip'])) {
            $pipeline[] = ['$skip' => $this->countOptions['skip']];
        }
        if (isset($this->countOptions['limit'])) {
            $pipeline[] = ['$limit' => $this->countOptions['limit']];
        }
        $pipeline[] = ['$group' => ['_id' => 1, 'n' => ['$sum' => 1]]];
        return new Aggregate($this->databaseName, $this->collectionName, $pipeline, $this->aggregateOptions);
    }
}