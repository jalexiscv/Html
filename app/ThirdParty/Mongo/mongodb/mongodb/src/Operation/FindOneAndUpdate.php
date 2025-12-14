<?php

namespace MongoDB\Operation;

use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnsupportedException;
use function array_key_exists;
use function is_array;
use function is_integer;
use function is_object;
use function MongoDB\is_first_key_operator;
use function MongoDB\is_pipeline;

class FindOneAndUpdate implements Executable, Explainable
{
    public const RETURN_DOCUMENT_BEFORE = 1;
    public const RETURN_DOCUMENT_AFTER = 2;
    private $findAndModify;

    public function __construct(string $databaseName, string $collectionName, $filter, $update, array $options = [])
    {
        if (!is_array($filter) && !is_object($filter)) {
            throw InvalidArgumentException::invalidType('$filter', $filter, 'array or object');
        }
        if (!is_array($update) && !is_object($update)) {
            throw InvalidArgumentException::invalidType('$update', $update, 'array or object');
        }
        if (!is_first_key_operator($update) && !is_pipeline($update)) {
            throw new InvalidArgumentException('Expected an update document with operator as first key or a pipeline');
        }
        if (isset($options['projection']) && !is_array($options['projection']) && !is_object($options['projection'])) {
            throw InvalidArgumentException::invalidType('"projection" option', $options['projection'], 'array or object');
        }
        if (array_key_exists('returnDocument', $options) && !is_integer($options['returnDocument'])) {
            throw InvalidArgumentException::invalidType('"returnDocument" option', $options['returnDocument'], 'integer');
        }
        if (isset($options['returnDocument']) && $options['returnDocument'] !== self::RETURN_DOCUMENT_AFTER && $options['returnDocument'] !== self::RETURN_DOCUMENT_BEFORE) {
            throw new InvalidArgumentException('Invalid value for "returnDocument" option: ' . $options['returnDocument']);
        }
        if (isset($options['projection'])) {
            $options['fields'] = $options['projection'];
        }
        if (isset($options['returnDocument'])) {
            $options['new'] = $options['returnDocument'] === self::RETURN_DOCUMENT_AFTER;
        }
        unset($options['projection'], $options['returnDocument']);
        $this->findAndModify = new FindAndModify($databaseName, $collectionName, ['query' => $filter, 'update' => $update] + $options);
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