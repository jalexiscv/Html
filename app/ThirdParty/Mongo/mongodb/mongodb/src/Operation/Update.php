<?php

namespace MongoDB\Operation;

use MongoDB\Driver\BulkWrite as Bulk;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Driver\Session;
use MongoDB\Driver\WriteConcern;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnsupportedException;
use MongoDB\UpdateResult;
use function is_array;
use function is_bool;
use function is_object;
use function is_string;
use function MongoDB\is_first_key_operator;
use function MongoDB\is_pipeline;
use function MongoDB\is_write_concern_acknowledged;
use function MongoDB\server_supports_feature;

class Update implements Executable, Explainable
{
    private static $wireVersionForHint = 8;
    private $databaseName;
    private $collectionName;
    private $filter;
    private $update;
    private $options;

    public function __construct(string $databaseName, string $collectionName, $filter, $update, array $options = [])
    {
        if (!is_array($filter) && !is_object($filter)) {
            throw InvalidArgumentException::invalidType('$filter', $filter, 'array or object');
        }
        if (!is_array($update) && !is_object($update)) {
            throw InvalidArgumentException::invalidType('$update', $filter, 'array or object');
        }
        $options += ['multi' => false, 'upsert' => false,];
        if (isset($options['arrayFilters']) && !is_array($options['arrayFilters'])) {
            throw InvalidArgumentException::invalidType('"arrayFilters" option', $options['arrayFilters'], 'array');
        }
        if (isset($options['bypassDocumentValidation']) && !is_bool($options['bypassDocumentValidation'])) {
            throw InvalidArgumentException::invalidType('"bypassDocumentValidation" option', $options['bypassDocumentValidation'], 'boolean');
        }
        if (isset($options['collation']) && !is_array($options['collation']) && !is_object($options['collation'])) {
            throw InvalidArgumentException::invalidType('"collation" option', $options['collation'], 'array or object');
        }
        if (isset($options['hint']) && !is_string($options['hint']) && !is_array($options['hint']) && !is_object($options['hint'])) {
            throw InvalidArgumentException::invalidType('"hint" option', $options['hint'], ['string', 'array', 'object']);
        }
        if (!is_bool($options['multi'])) {
            throw InvalidArgumentException::invalidType('"multi" option', $options['multi'], 'boolean');
        }
        if ($options['multi'] && !is_first_key_operator($update) && !is_pipeline($update)) {
            throw new InvalidArgumentException('"multi" option cannot be true if $update is a replacement document');
        }
        if (isset($options['session']) && !$options['session'] instanceof Session) {
            throw InvalidArgumentException::invalidType('"session" option', $options['session'], Session::class);
        }
        if (!is_bool($options['upsert'])) {
            throw InvalidArgumentException::invalidType('"upsert" option', $options['upsert'], 'boolean');
        }
        if (isset($options['writeConcern']) && !$options['writeConcern'] instanceof WriteConcern) {
            throw InvalidArgumentException::invalidType('"writeConcern" option', $options['writeConcern'], WriteConcern::class);
        }
        if (isset($options['let']) && !is_array($options['let']) && !is_object($options['let'])) {
            throw InvalidArgumentException::invalidType('"let" option', $options['let'], 'array or object');
        }
        if (isset($options['bypassDocumentValidation']) && !$options['bypassDocumentValidation']) {
            unset($options['bypassDocumentValidation']);
        }
        if (isset($options['writeConcern']) && $options['writeConcern']->isDefault()) {
            unset($options['writeConcern']);
        }
        $this->databaseName = $databaseName;
        $this->collectionName = $collectionName;
        $this->filter = $filter;
        $this->update = $update;
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
        $bulk->update($this->filter, $this->update, $this->createUpdateOptions());
        $writeResult = $server->executeBulkWrite($this->databaseName . '.' . $this->collectionName, $bulk, $this->createExecuteOptions());
        return new UpdateResult($writeResult);
    }

    public function getCommandDocument(Server $server)
    {
        $cmd = ['update' => $this->collectionName, 'updates' => [['q' => $this->filter, 'u' => $this->update] + $this->createUpdateOptions()]];
        if (isset($this->options['bypassDocumentValidation'])) {
            $cmd['bypassDocumentValidation'] = $this->options['bypassDocumentValidation'];
        }
        if (isset($this->options['writeConcern'])) {
            $cmd['writeConcern'] = $this->options['writeConcern'];
        }
        return $cmd;
    }

    private function createBulkWriteOptions(): array
    {
        $options = [];
        foreach (['bypassDocumentValidation', 'comment'] as $option) {
            if (isset($this->options[$option])) {
                $options[$option] = $this->options[$option];
            }
        }
        if (isset($this->options['let'])) {
            $options['let'] = (object)$this->options['let'];
        }
        return $options;
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

    private function createUpdateOptions(): array
    {
        $updateOptions = ['multi' => $this->options['multi'], 'upsert' => $this->options['upsert'],];
        foreach (['arrayFilters', 'hint'] as $option) {
            if (isset($this->options[$option])) {
                $updateOptions[$option] = $this->options[$option];
            }
        }
        if (isset($this->options['collation'])) {
            $updateOptions['collation'] = (object)$this->options['collation'];
        }
        return $updateOptions;
    }
}