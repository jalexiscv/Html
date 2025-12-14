<?php

namespace MongoDB\Operation;

use MongoDB\DeleteResult;
use MongoDB\Driver\BulkWrite as Bulk;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Driver\Session;
use MongoDB\Driver\WriteConcern;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnsupportedException;
use function is_array;
use function is_object;
use function is_string;
use function MongoDB\is_write_concern_acknowledged;
use function MongoDB\server_supports_feature;

class Delete implements Executable, Explainable
{
    private static $wireVersionForHint = 9;
    private $databaseName;
    private $collectionName;
    private $filter;
    private $limit;
    private $options;

    public function __construct(string $databaseName, string $collectionName, $filter, int $limit, array $options = [])
    {
        if (!is_array($filter) && !is_object($filter)) {
            throw InvalidArgumentException::invalidType('$filter', $filter, 'array or object');
        }
        if ($limit !== 0 && $limit !== 1) {
            throw new InvalidArgumentException('$limit must be 0 or 1');
        }
        if (isset($options['collation']) && !is_array($options['collation']) && !is_object($options['collation'])) {
            throw InvalidArgumentException::invalidType('"collation" option', $options['collation'], 'array or object');
        }
        if (isset($options['hint']) && !is_string($options['hint']) && !is_array($options['hint']) && !is_object($options['hint'])) {
            throw InvalidArgumentException::invalidType('"hint" option', $options['hint'], ['string', 'array', 'object']);
        }
        if (isset($options['session']) && !$options['session'] instanceof Session) {
            throw InvalidArgumentException::invalidType('"session" option', $options['session'], Session::class);
        }
        if (isset($options['writeConcern']) && !$options['writeConcern'] instanceof WriteConcern) {
            throw InvalidArgumentException::invalidType('"writeConcern" option', $options['writeConcern'], WriteConcern::class);
        }
        if (isset($options['let']) && !is_array($options['let']) && !is_object($options['let'])) {
            throw InvalidArgumentException::invalidType('"let" option', $options['let'], 'array or object');
        }
        if (isset($options['writeConcern']) && $options['writeConcern']->isDefault()) {
            unset($options['writeConcern']);
        }
        $this->databaseName = $databaseName;
        $this->collectionName = $collectionName;
        $this->filter = $filter;
        $this->limit = $limit;
        $this->options = $options;
    }

    public function execute(Server $server)
    {
        if (isset($this->options['writeConcern']) && !is_write_concern_acknowledged($this->options['writeConcern']) && isset($this->options['hint']) && !server_supports_feature($server, self::$wireVersionForHint)) {
            throw UnsupportedException::hintNotSupported();
        }
        $inTransaction = isset($this->options['session']) && $this->options['session']->isInTransaction();
        if ($inTransaction && isset($this->options['writeConcern'])) {
            throw UnsupportedException::writeConcernNotSupportedInTransaction();
        }
        $bulk = new Bulk($this->createBulkWriteOptions());
        $bulk->delete($this->filter, $this->createDeleteOptions());
        $writeResult = $server->executeBulkWrite($this->databaseName . '.' . $this->collectionName, $bulk, $this->createExecuteOptions());
        return new DeleteResult($writeResult);
    }

    public function getCommandDocument(Server $server)
    {
        $cmd = ['delete' => $this->collectionName, 'deletes' => [['q' => $this->filter] + $this->createDeleteOptions()]];
        if (isset($this->options['writeConcern'])) {
            $cmd['writeConcern'] = $this->options['writeConcern'];
        }
        return $cmd;
    }

    private function createBulkWriteOptions(): array
    {
        $options = [];
        if (isset($this->options['comment'])) {
            $options['comment'] = $this->options['comment'];
        }
        if (isset($this->options['let'])) {
            $options['let'] = (object)$this->options['let'];
        }
        return $options;
    }

    private function createDeleteOptions(): array
    {
        $deleteOptions = ['limit' => $this->limit];
        if (isset($this->options['collation'])) {
            $deleteOptions['collation'] = (object)$this->options['collation'];
        }
        if (isset($this->options['hint'])) {
            $deleteOptions['hint'] = $this->options['hint'];
        }
        return $deleteOptions;
    }

    private function createExecuteOptions(): array
    {
        $options = [];
        if (isset($this->options['session'])) {
            $options['session'] = $this->options['session'];
        }
        if (isset($this->options['writeConcern'])) {
            $options['writeConcern'] = $this->options['writeConcern'];
        }
        return $options;
    }
}