<?php

namespace MongoDB;

use MongoDB\Driver\WriteResult;
use MongoDB\Exception\BadMethodCallException;

class InsertOneResult
{
    private $writeResult;
    private $insertedId;
    private $isAcknowledged;

    public function __construct(WriteResult $writeResult, $insertedId)
    {
        $this->writeResult = $writeResult;
        $this->insertedId = $insertedId;
        $this->isAcknowledged = $writeResult->isAcknowledged();
    }

    public function getInsertedCount()
    {
        if ($this->isAcknowledged) {
            return $this->writeResult->getInsertedCount();
        }
        throw BadMethodCallException::unacknowledgedWriteResultAccess(__METHOD__);
    }

    public function getInsertedId()
    {
        return $this->insertedId;
    }

    public function isAcknowledged()
    {
        return $this->writeResult->isAcknowledged();
    }
}