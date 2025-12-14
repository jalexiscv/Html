<?php

namespace MongoDB\Operation;

use ArrayIterator;
use MongoDB\Driver\Command;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\ReadConcern;
use MongoDB\Driver\ReadPreference;
use MongoDB\Driver\Server;
use MongoDB\Driver\Session;
use MongoDB\Driver\WriteConcern;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnexpectedValueException;
use MongoDB\Exception\UnsupportedException;
use stdClass;
use function current;
use function is_array;
use function is_bool;
use function is_integer;
use function is_object;
use function is_string;
use function MongoDB\create_field_path_type_map;
use function MongoDB\is_last_pipeline_operator_write;
use function sprintf;

class Aggregate implements Executable, Explainable
{
    private $databaseName;
    private $collectionName;
    private $pipeline;
    private $options;
    private $isExplain;
    private $isWrite;

    public function __construct(string $databaseName, ?string $collectionName, array $pipeline, array $options = [])
    {
        $expectedIndex = 0;
        foreach ($pipeline as $i => $operation) {
            if ($i !== $expectedIndex) {
                throw new InvalidArgumentException(sprintf('$pipeline is not a list (unexpected index: "%s")', $i));
            }
            if (!is_array($operation) && !is_object($operation)) {
                throw InvalidArgumentException::invalidType(sprintf('$pipeline[%d]', $i), $operation, 'array or object');
            }
            $expectedIndex += 1;
        }
        $options += ['useCursor' => true];
        if (isset($options['allowDiskUse']) && !is_bool($options['allowDiskUse'])) {
            throw InvalidArgumentException::invalidType('"allowDiskUse" option', $options['allowDiskUse'], 'boolean');
        }
        if (isset($options['batchSize']) && !is_integer($options['batchSize'])) {
            throw InvalidArgumentException::invalidType('"batchSize" option', $options['batchSize'], 'integer');
        }
        if (isset($options['bypassDocumentValidation']) && !is_bool($options['bypassDocumentValidation'])) {
            throw InvalidArgumentException::invalidType('"bypassDocumentValidation" option', $options['bypassDocumentValidation'], 'boolean');
        }
        if (isset($options['collation']) && !is_array($options['collation']) && !is_object($options['collation'])) {
            throw InvalidArgumentException::invalidType('"collation" option', $options['collation'], 'array or object');
        }
        if (isset($options['explain']) && !is_bool($options['explain'])) {
            throw InvalidArgumentException::invalidType('"explain" option', $options['explain'], 'boolean');
        }
        if (isset($options['hint']) && !is_string($options['hint']) && !is_array($options['hint']) && !is_object($options['hint'])) {
            throw InvalidArgumentException::invalidType('"hint" option', $options['hint'], 'string or array or object');
        }
        if (isset($options['let']) && !is_array($options['let']) && !is_object($options['let'])) {
            throw InvalidArgumentException::invalidType('"let" option', $options['let'], ['array', 'object']);
        }
        if (isset($options['maxAwaitTimeMS']) && !is_integer($options['maxAwaitTimeMS'])) {
            throw InvalidArgumentException::invalidType('"maxAwaitTimeMS" option', $options['maxAwaitTimeMS'], 'integer');
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
        if (!is_bool($options['useCursor'])) {
            throw InvalidArgumentException::invalidType('"useCursor" option', $options['useCursor'], 'boolean');
        }
        if (isset($options['writeConcern']) && !$options['writeConcern'] instanceof WriteConcern) {
            throw InvalidArgumentException::invalidType('"writeConcern" option', $options['writeConcern'], WriteConcern::class);
        }
        if (isset($options['batchSize']) && !$options['useCursor']) {
            throw new InvalidArgumentException('"batchSize" option should not be used if "useCursor" is false');
        }
        if (isset($options['bypassDocumentValidation']) && !$options['bypassDocumentValidation']) {
            unset($options['bypassDocumentValidation']);
        }
        if (isset($options['readConcern']) && $options['readConcern']->isDefault()) {
            unset($options['readConcern']);
        }
        if (isset($options['writeConcern']) && $options['writeConcern']->isDefault()) {
            unset($options['writeConcern']);
        }
        $this->isExplain = !empty($options['explain']);
        $this->isWrite = is_last_pipeline_operator_write($pipeline) && !$this->isExplain;
        if ($this->isExplain) {
            $options['useCursor'] = false;
            unset($options['batchSize']);
        }
        if ($this->isWrite) {
            unset($options['batchSize']);
        }
        $this->databaseName = $databaseName;
        $this->collectionName = $collectionName;
        $this->pipeline = $pipeline;
        $this->options = $options;
    }

    public function execute(Server $server)
    {
        $inTransaction = isset($this->options['session']) && $this->options['session']->isInTransaction();
        if ($inTransaction) {
            if (isset($this->options['readConcern'])) {
                throw UnsupportedException::readConcernNotSupportedInTransaction();
            }
            if (isset($this->options['writeConcern'])) {
                throw UnsupportedException::writeConcernNotSupportedInTransaction();
            }
        }
        $command = new Command($this->createCommandDocument(), $this->createCommandOptions());
        $cursor = $this->executeCommand($server, $command);
        if ($this->options['useCursor'] || $this->isExplain) {
            if (isset($this->options['typeMap'])) {
                $cursor->setTypeMap($this->options['typeMap']);
            }
            return $cursor;
        }
        if (isset($this->options['typeMap'])) {
            $cursor->setTypeMap(create_field_path_type_map($this->options['typeMap'], 'result.$'));
        }
        $result = current($cursor->toArray());
        if (!is_object($result) || !isset($result->result) || !is_array($result->result)) {
            throw new UnexpectedValueException('aggregate command did not return a "result" array');
        }
        return new ArrayIterator($result->result);
    }

    public function getCommandDocument(Server $server)
    {
        return $this->createCommandDocument();
    }

    private function createCommandDocument(): array
    {
        $cmd = ['aggregate' => $this->collectionName ?? 1, 'pipeline' => $this->pipeline,];
        foreach (['allowDiskUse', 'bypassDocumentValidation', 'comment', 'explain', 'maxTimeMS'] as $option) {
            if (isset($this->options[$option])) {
                $cmd[$option] = $this->options[$option];
            }
        }
        foreach (['collation', 'let'] as $option) {
            if (isset($this->options[$option])) {
                $cmd[$option] = (object)$this->options[$option];
            }
        }
        if (isset($this->options['hint'])) {
            $cmd['hint'] = is_array($this->options['hint']) ? (object)$this->options['hint'] : $this->options['hint'];
        }
        if ($this->options['useCursor']) {
            $cmd['cursor'] = isset($this->options["batchSize"]) ? ['batchSize' => $this->options["batchSize"]] : new stdClass();
        }
        return $cmd;
    }

    private function createCommandOptions(): array
    {
        $cmdOptions = [];
        if (isset($this->options['maxAwaitTimeMS'])) {
            $cmdOptions['maxAwaitTimeMS'] = $this->options['maxAwaitTimeMS'];
        }
        return $cmdOptions;
    }

    private function executeCommand(Server $server, Command $command): Cursor
    {
        $options = [];
        foreach (['readConcern', 'readPreference', 'session'] as $option) {
            if (isset($this->options[$option])) {
                $options[$option] = $this->options[$option];
            }
        }
        if ($this->isWrite && isset($this->options['writeConcern'])) {
            $options['writeConcern'] = $this->options['writeConcern'];
        }
        if (!$this->isWrite) {
            return $server->executeReadCommand($this->databaseName, $command, $options);
        }
        if (isset($options['readPreference'])) {
            return $server->executeCommand($this->databaseName, $command, $options);
        }
        return $server->executeReadWriteCommand($this->databaseName, $command, $options);
    }
}