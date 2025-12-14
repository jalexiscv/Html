<?php

namespace MongoDB\Operation;

use MongoDB\Driver\Command;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Server;
use MongoDB\Driver\Session;
use MongoDB\Driver\WriteConcern;
use MongoDB\Exception\InvalidArgumentException;
use function current;
use function is_array;

class ModifyCollection implements Executable
{
    private $databaseName;
    private $collectionName;
    private $collectionOptions;
    private $options;

    public function __construct(string $databaseName, string $collectionName, array $collectionOptions, array $options = [])
    {
        if (empty($collectionOptions)) {
            throw new InvalidArgumentException('$collectionOptions is empty');
        }
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
        $this->databaseName = $databaseName;
        $this->collectionName = $collectionName;
        $this->collectionOptions = $collectionOptions;
        $this->options = $options;
    }

    public function execute(Server $server)
    {
        $cursor = $server->executeWriteCommand($this->databaseName, $this->createCommand(), $this->createOptions());
        if (isset($this->options['typeMap'])) {
            $cursor->setTypeMap($this->options['typeMap']);
        }
        return current($cursor->toArray());
    }

    private function createCommand(): Command
    {
        $cmd = ['collMod' => $this->collectionName] + $this->collectionOptions;
        if (isset($this->options['comment'])) {
            $cmd['comment'] = $this->options['comment'];
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