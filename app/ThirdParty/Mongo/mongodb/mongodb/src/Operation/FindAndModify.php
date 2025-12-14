<?php

namespace MongoDB\Operation;

use MongoDB\Driver\Command;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Driver\Session;
use MongoDB\Driver\WriteConcern;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnexpectedValueException;
use MongoDB\Exception\UnsupportedException;
use function array_key_exists;
use function current;
use function is_array;
use function is_bool;
use function is_integer;
use function is_object;
use function is_string;
use function MongoDB\create_field_path_type_map;
use function MongoDB\is_pipeline;
use function MongoDB\is_write_concern_acknowledged;
use function MongoDB\server_supports_feature;

class FindAndModify implements Executable, Explainable
{
    private static $wireVersionForHint = 9;
    private static $wireVersionForUnsupportedOptionServerSideError = 8;
    private $databaseName;
    private $collectionName;
    private $options;

    public function __construct(string $databaseName, string $collectionName, array $options)
    {
        $options += ['remove' => false];
        if (isset($options['arrayFilters']) && !is_array($options['arrayFilters'])) {
            throw InvalidArgumentException::invalidType('"arrayFilters" option', $options['arrayFilters'], 'array');
        }
        if (isset($options['bypassDocumentValidation']) && !is_bool($options['bypassDocumentValidation'])) {
            throw InvalidArgumentException::invalidType('"bypassDocumentValidation" option', $options['bypassDocumentValidation'], 'boolean');
        }
        if (isset($options['collation']) && !is_array($options['collation']) && !is_object($options['collation'])) {
            throw InvalidArgumentException::invalidType('"collation" option', $options['collation'], 'array or object');
        }
        if (isset($options['fields']) && !is_array($options['fields']) && !is_object($options['fields'])) {
            throw InvalidArgumentException::invalidType('"fields" option', $options['fields'], 'array or object');
        }
        if (isset($options['hint']) && !is_string($options['hint']) && !is_array($options['hint']) && !is_object($options['hint'])) {
            throw InvalidArgumentException::invalidType('"hint" option', $options['hint'], ['string', 'array', 'object']);
        }
        if (isset($options['maxTimeMS']) && !is_integer($options['maxTimeMS'])) {
            throw InvalidArgumentException::invalidType('"maxTimeMS" option', $options['maxTimeMS'], 'integer');
        }
        if (array_key_exists('new', $options) && !is_bool($options['new'])) {
            throw InvalidArgumentException::invalidType('"new" option', $options['new'], 'boolean');
        }
        if (isset($options['query']) && !is_array($options['query']) && !is_object($options['query'])) {
            throw InvalidArgumentException::invalidType('"query" option', $options['query'], 'array or object');
        }
        if (!is_bool($options['remove'])) {
            throw InvalidArgumentException::invalidType('"remove" option', $options['remove'], 'boolean');
        }
        if (isset($options['session']) && !$options['session'] instanceof Session) {
            throw InvalidArgumentException::invalidType('"session" option', $options['session'], Session::class);
        }
        if (isset($options['sort']) && !is_array($options['sort']) && !is_object($options['sort'])) {
            throw InvalidArgumentException::invalidType('"sort" option', $options['sort'], 'array or object');
        }
        if (isset($options['typeMap']) && !is_array($options['typeMap'])) {
            throw InvalidArgumentException::invalidType('"typeMap" option', $options['typeMap'], 'array');
        }
        if (isset($options['update']) && !is_array($options['update']) && !is_object($options['update'])) {
            throw InvalidArgumentException::invalidType('"update" option', $options['update'], 'array or object');
        }
        if (isset($options['writeConcern']) && !$options['writeConcern'] instanceof WriteConcern) {
            throw InvalidArgumentException::invalidType('"writeConcern" option', $options['writeConcern'], WriteConcern::class);
        }
        if (array_key_exists('upsert', $options) && !is_bool($options['upsert'])) {
            throw InvalidArgumentException::invalidType('"upsert" option', $options['upsert'], 'boolean');
        }
        if (isset($options['let']) && !is_array($options['let']) && !is_object($options['let'])) {
            throw InvalidArgumentException::invalidType('"let" option', $options['let'], 'array or object');
        }
        if (isset($options['bypassDocumentValidation']) && !$options['bypassDocumentValidation']) {
            unset($options['bypassDocumentValidation']);
        }
        if (!(isset($options['update']) xor $options['remove'])) {
            throw new InvalidArgumentException('The "remove" option must be true or an "update" document must be specified, but not both');
        }
        if (isset($options['writeConcern']) && $options['writeConcern']->isDefault()) {
            unset($options['writeConcern']);
        }
        $this->databaseName = $databaseName;
        $this->collectionName = $collectionName;
        $this->options = $options;
    }

    public function execute(Server $server)
    {
        if (isset($this->options['hint']) && !server_supports_feature($server, self::$wireVersionForUnsupportedOptionServerSideError)) {
            throw UnsupportedException::hintNotSupported();
        }
        if (isset($this->options['writeConcern']) && !is_write_concern_acknowledged($this->options['writeConcern']) && isset($this->options['hint']) && !server_supports_feature($server, self::$wireVersionForHint)) {
            throw UnsupportedException::hintNotSupported();
        }
        $inTransaction = isset($this->options['session']) && $this->options['session']->isInTransaction();
        if ($inTransaction && isset($this->options['writeConcern'])) {
            throw UnsupportedException::writeConcernNotSupportedInTransaction();
        }
        $cursor = $server->executeWriteCommand($this->databaseName, new Command($this->createCommandDocument()), $this->createOptions());
        if (isset($this->options['typeMap'])) {
            $cursor->setTypeMap(create_field_path_type_map($this->options['typeMap'], 'value'));
        }
        $result = current($cursor->toArray());
        return is_object($result) ? ($result->value ?? null) : null;
    }

    public function getCommandDocument(Server $server)
    {
        return $this->createCommandDocument();
    }

    private function createCommandDocument(): array
    {
        $cmd = ['findAndModify' => $this->collectionName];
        if ($this->options['remove']) {
            $cmd['remove'] = true;
        } else {
            if (isset($this->options['new'])) {
                $cmd['new'] = $this->options['new'];
            }
            if (isset($this->options['upsert'])) {
                $cmd['upsert'] = $this->options['upsert'];
            }
        }
        foreach (['collation', 'fields', 'let', 'query', 'sort'] as $option) {
            if (isset($this->options[$option])) {
                $cmd[$option] = (object)$this->options[$option];
            }
        }
        if (isset($this->options['update'])) {
            $cmd['update'] = is_pipeline($this->options['update']) ? $this->options['update'] : (object)$this->options['update'];
        }
        foreach (['arrayFilters', 'bypassDocumentValidation', 'comment', 'hint', 'maxTimeMS'] as $option) {
            if (isset($this->options[$option])) {
                $cmd[$option] = $this->options[$option];
            }
        }
        return $cmd;
    }

    private function createOptions(): array
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