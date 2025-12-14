<?php

namespace MongoDB;

use IteratorAggregate;
use ReturnTypeWillChange;
use stdClass;
use Traversable;
use function call_user_func;

class MapReduceResult implements IteratorAggregate
{
    private $getIterator;
    private $executionTimeMS;
    private $counts;
    private $timing;

    public function __construct(callable $getIterator, stdClass $result)
    {
        $this->getIterator = $getIterator;
        $this->executionTimeMS = isset($result->timeMillis) ? (integer)$result->timeMillis : 0;
        $this->counts = isset($result->counts) ? (array)$result->counts : [];
        $this->timing = isset($result->timing) ? (array)$result->timing : [];
    }

    public function getCounts()
    {
        return $this->counts;
    }

    public function getExecutionTimeMS()
    {
        return $this->executionTimeMS;
    }

    #[ReturnTypeWillChange] public function getIterator()
    {
        return call_user_func($this->getIterator);
    }

    public function getTiming()
    {
        return $this->timing;
    }
}