<?php

namespace MongoDB\Operation;

use MongoDB\Driver\Command;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\ReadConcern;
use MongoDB\Driver\ReadPreference;
use MongoDB\Driver\Server;
use MongoDB\Driver\Session;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnexpectedValueException;
use MongoDB\Exception\UnsupportedException;
use function current;
use function is_array;
use function is_integer;
use function is_object;
use function MongoDB\create_field_path_type_map;

class Distinct implements Executable, Explainable
{
    private $databaseName;
    private $collectionName;
    private $fieldName;
    private $filter;
    private $options;

    public function __construct(string $databaseName, string $collectionName, string $fieldName, $filter = [], array $options = [])
    {
        if (!is_array($filter) && !is_object($filter)) {
            throw InvalidArgumentException::invalidType('$filter', $filter, 'array or object');
        }
        if (isset($options['collation']) && !is_array($options['collation']) && !is_object($options['collation'])) {
            throw InvalidArgumentException::invalidType('"collation" option', $options['collation'], 'array or object');
        }
        if (isset($options['maxTimeMS']) && !is_integer($options['maxTimeMS'])) {
            throw InvalidArgumentException::invalidType('"maxTimeMS" option', $options['maxTimeMS'], 'integer');
        }
        if (isset($options['readConcern']) && !$options['readConcern'] instanceof ReadConcern) {
            throw InvalidArgumentException::invalidType('"readConcern" option', $options['readConcern'], ReadConcern::class);
        }
        if (isset($options['readPreference']) && !$options['readPreference'] instanceof ReadPreference) {
            throw InvalidArgumentException::invalidType('"readPreference" option', $options['readPreference'], ReadPreference::class);
        }
        if (isset($options['session']) && !$options['session'] instanceof Session) {
            throw InvalidArgumentException::invalidType('"session" option', $options['session'], Session::class);
        }
        if (isset($options['typeMap']) && !is_array($options['typeMap'])) {
            throw InvalidArgumentException::invalidType('"typeMap" option', $options['typeMap'], 'array');
        }
        if (isset($options['readConcern']) && $options['readConcern']->isDefault()) {
            unset($options['readConcern']);
        }
        $this->databaseName = $databaseName;
        $this->collectionName = $collectionName;
        $this->fieldName = $fieldName;
        $this->filter = $filter;
        $this->options = $options;
    }

    public function execute(Server $server)
    {
        $inTransaction = isset($this->options['session']) && $this->options['session']->isInTransaction();
        if ($inTransaction && isset($this->options['readConcern'])) {
            throw UnsupportedException::readConcernNotSupportedInTransaction();
        }
        $cursor = $server->executeReadCommand($this->databaseName, new Command($this->createCommandDocument()), $this->createOptions());
        if (isset($this->options['typeMap'])) {
            $cursor->setTypeMap(create_field_path_type_map($this->options['typeMap'], 'values.$'));
        }
        $result = current($cursor->toArray());
        if (!is_object($result) || !isset($result->values) || !is_array($result->values)) {
            throw new UnexpectedValueException('distinct command did not return a "values" array');
        }
        return $result->values;
    }

    public function getCommandDocument(Server $server)
    {
        return $this->createCommandDocument();
    }

    private function createCommandDocument(): array
    {
        $cmd = ['distinct' => $this->collectionName, 'key' => $this->fieldName,];
        if (!empty($this->filter)) {
            $cmd['query'] = (object)$this->filter;
        }
        if (isset($this->options['collation'])) {
            $cmd['collation'] = (object)$this->options['collation'];
        }
        foreach (['comment', 'maxTimeMS'] as $option) {
            if (isset($this->options[$option])) {
                $cmd[$option] = $this->options[$option];
            }
        }
        return $cmd;
    }

    private function createOptions(): array
    {
        $options = [];
        if (isset($this->options['readConcern'])) {
            $options['readConcern'] = $this->options['readConcern'];
        }
        if (isset($this->options['readPreference'])) {
            $options['readPreference'] = $this->options['readPreference'];
        }
        if (isset($this->options['session'])) {
            $options['session'] = $this->options['session'];
        }
        return $options;
    }
}