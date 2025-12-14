<?php

namespace MongoDB\Operation;

use MongoDB\BulkWriteResult;
use MongoDB\Driver\BulkWrite as Bulk;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Driver\Session;
use MongoDB\Driver\WriteConcern;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnsupportedException;
use function array_key_exists;
use function count;
use function current;
use function is_array;
use function is_bool;
use function is_object;
use function key;
use function MongoDB\is_first_key_operator;
use function MongoDB\is_pipeline;
use function sprintf;

class BulkWrite implements Executable
{
    public const DELETE_MANY = 'deleteMany';
    public const DELETE_ONE = 'deleteOne';
    public const INSERT_ONE = 'insertOne';
    public const REPLACE_ONE = 'replaceOne';
    public const UPDATE_MANY = 'updateMany';
    public const UPDATE_ONE = 'updateOne';
    private $databaseName;
    private $collectionName;
    private $operations;
    private $options;

    public function __construct(string $databaseName, string $collectionName, array $operations, array $options = [])
    {
        if (empty($operations)) {
            throw new InvalidArgumentException('$operations is empty');
        }
        $expectedIndex = 0;
        foreach ($operations as $i => $operation) {
            if ($i !== $expectedIndex) {
                throw new InvalidArgumentException(sprintf('$operations is not a list (unexpected index: "%s")', $i));
            }
            if (!is_array($operation)) {
                throw InvalidArgumentException::invalidType(sprintf('$operations[%d]', $i), $operation, 'array');
            }
            if (count($operation) !== 1) {
                throw new InvalidArgumentException(sprintf('Expected one element in $operation[%d], actually: %d', $i, count($operation)));
            }
            $type = key($operation);
            $args = current($operation);
            if (!isset($args[0]) && !array_key_exists(0, $args)) {
                throw new InvalidArgumentException(sprintf('Missing first argument for $operations[%d]["%s"]', $i, $type));
            }
            if (!is_array($args[0]) && !is_object($args[0])) {
                throw InvalidArgumentException::invalidType(sprintf('$operations[%d]["%s"][0]', $i, $type), $args[0], 'array or object');
            }
            switch ($type) {
                case self::INSERT_ONE:
                    break;
                case self::DELETE_MANY:
                case self::DELETE_ONE:
                    if (!isset($args[1])) {
                        $args[1] = [];
                    }
                    if (!is_array($args[1])) {
                        throw InvalidArgumentException::invalidType(sprintf('$operations[%d]["%s"][1]', $i, $type), $args[1], 'array');
                    }
                    $args[1]['limit'] = ($type === self::DELETE_ONE ? 1 : 0);
                    if (isset($args[1]['collation']) && !is_array($args[1]['collation']) && !is_object($args[1]['collation'])) {
                        throw InvalidArgumentException::invalidType(sprintf('$operations[%d]["%s"][1]["collation"]', $i, $type), $args[1]['collation'], 'array or object');
                    }
                    $operations[$i][$type][1] = $args[1];
                    break;
                case self::REPLACE_ONE:
                    if (!isset($args[1]) && !array_key_exists(1, $args)) {
                        throw new InvalidArgumentException(sprintf('Missing second argument for $operations[%d]["%s"]', $i, $type));
                    }
                    if (!is_array($args[1]) && !is_object($args[1])) {
                        throw InvalidArgumentException::invalidType(sprintf('$operations[%d]["%s"][1]', $i, $type), $args[1], 'array or object');
                    }
                    if (is_first_key_operator($args[1])) {
                        throw new InvalidArgumentException(sprintf('First key in $operations[%d]["%s"][1] is an update operator', $i, $type));
                    }
                    if (!isset($args[2])) {
                        $args[2] = [];
                    }
                    if (!is_array($args[2])) {
                        throw InvalidArgumentException::invalidType(sprintf('$operations[%d]["%s"][2]', $i, $type), $args[2], 'array');
                    }
                    $args[2]['multi'] = false;
                    $args[2] += ['upsert' => false];
                    if (isset($args[2]['collation']) && !is_array($args[2]['collation']) && !is_object($args[2]['collation'])) {
                        throw InvalidArgumentException::invalidType(sprintf('$operations[%d]["%s"][2]["collation"]', $i, $type), $args[2]['collation'], 'array or object');
                    }
                    if (!is_bool($args[2]['upsert'])) {
                        throw InvalidArgumentException::invalidType(sprintf('$operations[%d]["%s"][2]["upsert"]', $i, $type), $args[2]['upsert'], 'boolean');
                    }
                    $operations[$i][$type][2] = $args[2];
                    break;
                case self::UPDATE_MANY:
                case self::UPDATE_ONE:
                    if (!isset($args[1]) && !array_key_exists(1, $args)) {
                        throw new InvalidArgumentException(sprintf('Missing second argument for $operations[%d]["%s"]', $i, $type));
                    }
                    if (!is_array($args[1]) && !is_object($args[1])) {
                        throw InvalidArgumentException::invalidType(sprintf('$operations[%d]["%s"][1]', $i, $type), $args[1], 'array or object');
                    }
                    if (!is_first_key_operator($args[1]) && !is_pipeline($args[1])) {
                        throw new InvalidArgumentException(sprintf('First key in $operations[%d]["%s"][1] is neither an update operator nor a pipeline', $i, $type));
                    }
                    if (!isset($args[2])) {
                        $args[2] = [];
                    }
                    if (!is_array($args[2])) {
                        throw InvalidArgumentException::invalidType(sprintf('$operations[%d]["%s"][2]', $i, $type), $args[2], 'array');
                    }
                    $args[2]['multi'] = ($type === self::UPDATE_MANY);
                    $args[2] += ['upsert' => false];
                    if (isset($args[2]['arrayFilters']) && !is_array($args[2]['arrayFilters'])) {
                        throw InvalidArgumentException::invalidType(sprintf('$operations[%d]["%s"][2]["arrayFilters"]', $i, $type), $args[2]['arrayFilters'], 'array');
                    }
                    if (isset($args[2]['collation']) && !is_array($args[2]['collation']) && !is_object($args[2]['collation'])) {
                        throw InvalidArgumentException::invalidType(sprintf('$operations[%d]["%s"][2]["collation"]', $i, $type), $args[2]['collation'], 'array or object');
                    }
                    if (!is_bool($args[2]['upsert'])) {
                        throw InvalidArgumentException::invalidType(sprintf('$operations[%d]["%s"][2]["upsert"]', $i, $type), $args[2]['upsert'], 'boolean');
                    }
                    $operations[$i][$type][2] = $args[2];
                    break;
                default:
                    throw new InvalidArgumentException(sprintf('Unknown operation type "%s" in $operations[%d]', $type, $i));
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
        $this->operations = $operations;
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
        foreach ($this->operations as $i => $operation) {
            $type = key($operation);
            $args = current($operation);
            switch ($type) {
                case self::DELETE_MANY:
                case self::DELETE_ONE:
                    $bulk->delete($args[0], $args[1]);
                    break;
                case self::INSERT_ONE:
                    $insertedIds[$i] = $bulk->insert($args[0]);
                    break;
                case self::REPLACE_ONE:
                case self::UPDATE_MANY:
                case self::UPDATE_ONE:
                    $bulk->update($args[0], $args[1], $args[2]);
            }
        }
        $writeResult = $server->executeBulkWrite($this->databaseName . '.' . $this->collectionName, $bulk, $this->createExecuteOptions());
        return new BulkWriteResult($writeResult, $insertedIds);
    }

    private function createBulkWriteOptions(): array
    {
        $options = ['ordered' => $this->options['ordered']];
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
}