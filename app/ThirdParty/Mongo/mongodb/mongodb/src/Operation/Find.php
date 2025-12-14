<?php

namespace MongoDB\Operation;

use MongoDB\Driver\Cursor;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Query;
use MongoDB\Driver\ReadConcern;
use MongoDB\Driver\ReadPreference;
use MongoDB\Driver\Server;
use MongoDB\Driver\Session;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnsupportedException;
use function is_array;
use function is_bool;
use function is_integer;
use function is_object;
use function is_string;
use function trigger_error;
use const E_USER_DEPRECATED;

class Find implements Executable, Explainable
{
    public const NON_TAILABLE = 1;
    public const TAILABLE = 2;
    public const TAILABLE_AWAIT = 3;
    private $databaseName;
    private $collectionName;
    private $filter;
    private $options;

    public function __construct(string $databaseName, string $collectionName, $filter, array $options = [])
    {
        if (!is_array($filter) && !is_object($filter)) {
            throw InvalidArgumentException::invalidType('$filter', $filter, 'array or object');
        }
        if (isset($options['allowDiskUse']) && !is_bool($options['allowDiskUse'])) {
            throw InvalidArgumentException::invalidType('"allowDiskUse" option', $options['allowDiskUse'], 'boolean');
        }
        if (isset($options['allowPartialResults']) && !is_bool($options['allowPartialResults'])) {
            throw InvalidArgumentException::invalidType('"allowPartialResults" option', $options['allowPartialResults'], 'boolean');
        }
        if (isset($options['batchSize']) && !is_integer($options['batchSize'])) {
            throw InvalidArgumentException::invalidType('"batchSize" option', $options['batchSize'], 'integer');
        }
        if (isset($options['collation']) && !is_array($options['collation']) && !is_object($options['collation'])) {
            throw InvalidArgumentException::invalidType('"collation" option', $options['collation'], 'array or object');
        }
        if (isset($options['cursorType'])) {
            if (!is_integer($options['cursorType'])) {
                throw InvalidArgumentException::invalidType('"cursorType" option', $options['cursorType'], 'integer');
            }
            if ($options['cursorType'] !== self::NON_TAILABLE && $options['cursorType'] !== self::TAILABLE && $options['cursorType'] !== self::TAILABLE_AWAIT) {
                throw new InvalidArgumentException('Invalid value for "cursorType" option: ' . $options['cursorType']);
            }
        }
        if (isset($options['hint']) && !is_string($options['hint']) && !is_array($options['hint']) && !is_object($options['hint'])) {
            throw InvalidArgumentException::invalidType('"hint" option', $options['hint'], 'string or array or object');
        }
        if (isset($options['limit']) && !is_integer($options['limit'])) {
            throw InvalidArgumentException::invalidType('"limit" option', $options['limit'], 'integer');
        }
        if (isset($options['max']) && !is_array($options['max']) && !is_object($options['max'])) {
            throw InvalidArgumentException::invalidType('"max" option', $options['max'], 'array or object');
        }
        if (isset($options['maxAwaitTimeMS']) && !is_integer($options['maxAwaitTimeMS'])) {
            throw InvalidArgumentException::invalidType('"maxAwaitTimeMS" option', $options['maxAwaitTimeMS'], 'integer');
        }
        if (isset($options['maxScan']) && !is_integer($options['maxScan'])) {
            throw InvalidArgumentException::invalidType('"maxScan" option', $options['maxScan'], 'integer');
        }
        if (isset($options['maxTimeMS']) && !is_integer($options['maxTimeMS'])) {
            throw InvalidArgumentException::invalidType('"maxTimeMS" option', $options['maxTimeMS'], 'integer');
        }
        if (isset($options['min']) && !is_array($options['min']) && !is_object($options['min'])) {
            throw InvalidArgumentException::invalidType('"min" option', $options['min'], 'array or object');
        }
        if (isset($options['modifiers']) && !is_array($options['modifiers']) && !is_object($options['modifiers'])) {
            throw InvalidArgumentException::invalidType('"modifiers" option', $options['modifiers'], 'array or object');
        }
        if (isset($options['noCursorTimeout']) && !is_bool($options['noCursorTimeout'])) {
            throw InvalidArgumentException::invalidType('"noCursorTimeout" option', $options['noCursorTimeout'], 'boolean');
        }
        if (isset($options['oplogReplay']) && !is_bool($options['oplogReplay'])) {
            throw InvalidArgumentException::invalidType('"oplogReplay" option', $options['oplogReplay'], 'boolean');
        }
        if (isset($options['projection']) && !is_array($options['projection']) && !is_object($options['projection'])) {
            throw InvalidArgumentException::invalidType('"projection" option', $options['projection'], 'array or object');
        }
        if (isset($options['readConcern']) && !$options['readConcern'] instanceof ReadConcern) {
            throw InvalidArgumentException::invalidType('"readConcern" option', $options['readConcern'], ReadConcern::class);
        }
        if (isset($options['readPreference']) && !$options['readPreference'] instanceof ReadPreference) {
            throw InvalidArgumentException::invalidType('"readPreference" option', $options['readPreference'], ReadPreference::class);
        }
        if (isset($options['returnKey']) && !is_bool($options['returnKey'])) {
            throw InvalidArgumentException::invalidType('"returnKey" option', $options['returnKey'], 'boolean');
        }
        if (isset($options['session']) && !$options['session'] instanceof Session) {
            throw InvalidArgumentException::invalidType('"session" option', $options['session'], Session::class);
        }
        if (isset($options['showRecordId']) && !is_bool($options['showRecordId'])) {
            throw InvalidArgumentException::invalidType('"showRecordId" option', $options['showRecordId'], 'boolean');
        }
        if (isset($options['skip']) && !is_integer($options['skip'])) {
            throw InvalidArgumentException::invalidType('"skip" option', $options['skip'], 'integer');
        }
        if (isset($options['snapshot']) && !is_bool($options['snapshot'])) {
            throw InvalidArgumentException::invalidType('"snapshot" option', $options['snapshot'], 'boolean');
        }
        if (isset($options['sort']) && !is_array($options['sort']) && !is_object($options['sort'])) {
            throw InvalidArgumentException::invalidType('"sort" option', $options['sort'], 'array or object');
        }
        if (isset($options['typeMap']) && !is_array($options['typeMap'])) {
            throw InvalidArgumentException::invalidType('"typeMap" option', $options['typeMap'], 'array');
        }
        if (isset($options['let']) && !is_array($options['let']) && !is_object($options['let'])) {
            throw InvalidArgumentException::invalidType('"let" option', $options['let'], 'array or object');
        }
        if (isset($options['readConcern']) && $options['readConcern']->isDefault()) {
            unset($options['readConcern']);
        }
        if (isset($options['snapshot'])) {
            trigger_error('The "snapshot" option is deprecated and will be removed in a future release', E_USER_DEPRECATED);
        }
        if (isset($options['maxScan'])) {
            trigger_error('The "maxScan" option is deprecated and will be removed in a future release', E_USER_DEPRECATED);
        }
        $this->databaseName = $databaseName;
        $this->collectionName = $collectionName;
        $this->filter = $filter;
        $this->options = $options;
    }

    public function execute(Server $server)
    {
        $inTransaction = isset($this->options['session']) && $this->options['session']->isInTransaction();
        if ($inTransaction && isset($this->options['readConcern'])) {
            throw UnsupportedException::readConcernNotSupportedInTransaction();
        }
        $cursor = $server->executeQuery($this->databaseName . '.' . $this->collectionName, new Query($this->filter, $this->createQueryOptions()), $this->createExecuteOptions());
        if (isset($this->options['typeMap'])) {
            $cursor->setTypeMap($this->options['typeMap']);
        }
        return $cursor;
    }

    public function getCommandDocument(Server $server)
    {
        return $this->createCommandDocument();
    }

    private function createCommandDocument(): array
    {
        $cmd = ['find' => $this->collectionName, 'filter' => (object)$this->filter];
        $options = $this->createQueryOptions();
        if (empty($options)) {
            return $cmd;
        }
        unset($options['maxAwaitTimeMS']);
        $modifierFallback = [['allowPartialResults', 'partial'], ['comment', '$comment'], ['hint', '$hint'], ['maxScan', '$maxScan'], ['max', '$max'], ['maxTimeMS', '$maxTimeMS'], ['min', '$min'], ['returnKey', '$returnKey'], ['showRecordId', '$showDiskLoc'], ['sort', '$orderby'], ['snapshot', '$snapshot'],];
        foreach ($modifierFallback as $modifier) {
            if (!isset($options[$modifier[0]]) && isset($options['modifiers'][$modifier[1]])) {
                $options[$modifier[0]] = $options['modifiers'][$modifier[1]];
            }
        }
        unset($options['modifiers']);
        return $cmd + $options;
    }

    private function createExecuteOptions(): array
    {
        $options = [];
        if (isset($this->options['readPreference'])) {
            $options['readPreference'] = $this->options['readPreference'];
        }
        if (isset($this->options['session'])) {
            $options['session'] = $this->options['session'];
        }
        return $options;
    }

    private function createQueryOptions(): array
    {
        $options = [];
        if (isset($this->options['cursorType'])) {
            if ($this->options['cursorType'] === self::TAILABLE) {
                $options['tailable'] = true;
            }
            if ($this->options['cursorType'] === self::TAILABLE_AWAIT) {
                $options['tailable'] = true;
                $options['awaitData'] = true;
            }
        }
        foreach (['allowDiskUse', 'allowPartialResults', 'batchSize', 'comment', 'hint', 'limit', 'maxAwaitTimeMS', 'maxScan', 'maxTimeMS', 'noCursorTimeout', 'oplogReplay', 'projection', 'readConcern', 'returnKey', 'showRecordId', 'skip', 'snapshot', 'sort'] as $option) {
            if (isset($this->options[$option])) {
                $options[$option] = $this->options[$option];
            }
        }
        foreach (['collation', 'let', 'max', 'min'] as $option) {
            if (isset($this->options[$option])) {
                $options[$option] = (object)$this->options[$option];
            }
        }
        $modifiers = empty($this->options['modifiers']) ? [] : (array)$this->options['modifiers'];
        if (!empty($modifiers)) {
            $options['modifiers'] = $modifiers;
        }
        return $options;
    }
}