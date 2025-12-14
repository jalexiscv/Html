<?php

namespace MongoDB\Operation;

use MongoDB\Driver\BulkWrite as Bulk;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Driver\Session;
use MongoDB\Driver\WriteConcern;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnsupportedException;
use MongoDB\InsertManyResult;
use function is_array;
use function is_bool;
use function is_object;
use function sprintf;

class InsertMany implements Executable
{
    private $databaseName;
    private $collectionName;
    private $documents;
    private $options;

    public function __construct(string $databaseName, string $collectionName, array $documents, array $options = [])
    {
        if (empty($documents)) {
            throw new InvalidArgumentException('$documents is empty');
        }
        $expectedIndex = 0;
        foreach ($documents as $i => $document) {
            if ($i !== $expectedIndex) {
                throw new InvalidArgumentException(sprintf('$documents is not a list (unexpected index: "%s")', $i));
            }
            if (!is_array($document) && !is_object($document)) {
                throw InvalidArgumentException::invalidType(sprintf('$documents[%d]', $i), $document, 'array or object');
            }
            $expectedIndex += 1;
        }
        $options += ['ordered' => true];
        if (isset($options['bypassDocumentValidation']) && !is_bool($options['bypassDocumentValidation'])) {
            throw InvalidArgumentException::invalidType('"bypassDocumentValidation" option', $options['bypassDocumentValidation'], 'boolean');
        }
        if (!is_bool($options['ordered'])) {
            throw InvalidArgumentException::invalidType('"ordered" option', $options['ordered'], 'boolean');
        }
        if (isset($options['session']) && !$options['session'] instanceof Session) {
            throw InvalidArgumentException::invalidType('"session" option', $options['session'], Session::class);
        }
        if (isset($options['writeConcern']) && !$options['writeConcern'] instanceof WriteConcern) {
            throw InvalidArgumentException::invalidType('"writeConcern" option', $options['writeConcern'], WriteConcern::class);
        }
        if (isset($options['bypassDocumentValidation']) && !$options['bypassDocumentValidation']) {
            unset($options['bypassDocumentValidation']);
        }
        if (isset($options['writeConcern']) && $options['writeConcern']->isDefault()) {
            unset($options['writeConcern']);
        }
        $this->databaseName = $databaseName;
        $this->collectionName = $collectionName;
        $this->documents = $documents;
        $this->options = $options;
    }

    public function execute(Server $server)
    {
        $inTransaction = isset($this->options['session']) && $this->options['session']->isInTransaction();
        if ($inTransaction && isset($this->options['writeConcern'])) {
            throw UnsupportedException::writeConcernNotSupportedInTransaction();
        }
        $bulk = new Bulk($this->createBulkWriteOptions());
        $insertedIds = [];
        foreach ($this->documents as $i => $document) {
            $insertedIds[$i] = $bulk->insert($document);
        }
        $writeResult = $server->executeBulkWrite($this->databaseName . '.' . $this->collectionName, $bulk, $this->createExecuteOptions());
        return new InsertManyResult($writeResult, $insertedIds);
    }

    private function createBulkWriteOptions(): array
    {
        $options = ['ordered' => $this->options['ordered']];
        foreach (['bypassDocumentValidation', 'comment'] as $option) {
            if (isset($this->options[$option])) {
                $options[$option] = $this->options[$option];
            }
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
}