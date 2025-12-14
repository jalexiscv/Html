<?php

namespace MongoDB\Operation;

use MongoDB\Driver\Command;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Driver\Session;
use MongoDB\Driver\WriteConcern;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnsupportedException;
use function current;
use function is_array;
use function is_bool;

class RenameCollection implements Executable
{
    private $fromNamespace;
    private $toNamespace;
    private $options;

    public function __construct(string $fromDatabaseName, string $fromCollectionName, string $toDatabaseName, string $toCollectionName, array $options = [])
    {
        if (isset($options['session']) && !$options['session'] instanceof Session) {
            throw InvalidArgumentException::invalidType('"session" option', $options['session'], Session::class);
        }
        if (isset($options['typeMap']) && !is_array($options['typeMap'])) {
            throw InvalidArgumentException::invalidType('"typeMap" option', $options['typeMap'], 'array');
        }
        if (isset($options['writeConcern']) && !$options['writeConcern'] instanceof WriteConcern) {
            throw InvalidArgumentException::invalidType('"writeConcern" option', $options['writeConcern'], WriteConcern::class);
        }
        if (isset($options['writeConcern']) && $options['writeConcern']->isDefault()) {
            unset($options['writeConcern']);
        }
        if (isset($options['dropTarget']) && !is_bool($options['dropTarget'])) {
            throw InvalidArgumentException::invalidType('"dropTarget" option', $options['dropTarget'], 'boolean');
        }
        $this->fromNamespace = $fromDatabaseName . '.' . $fromCollectionName;
        $this->toNamespace = $toDatabaseName . '.' . $toCollectionName;
        $this->options = $options;
    }

    public function execute(Server $server)
    {
        $inTransaction = isset($this->options['session']) && $this->options['session']->isInTransaction();
        if ($inTransaction && isset($this->options['writeConcern'])) {
            throw UnsupportedException::writeConcernNotSupportedInTransaction();
        }
        $cursor = $server->executeWriteCommand('admin', $this->createCommand(), $this->createOptions());
        if (isset($this->options['typeMap'])) {
            $cursor->setTypeMap($this->options['typeMap']);
        }
        return current($cursor->toArray());
    }

    private function createCommand(): Command
    {
        $cmd = ['renameCollection' => $this->fromNamespace, 'to' => $this->toNamespace,];
        foreach (['comment', 'dropTarget'] as $option) {
            if (isset($this->options[$option])) {
                $cmd[$option] = $this->options[$option];
            }
        }
        return new Command($cmd);
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