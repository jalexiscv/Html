<?php

namespace MongoDB\Operation;

use ArrayIterator;
use MongoDB\BSON\JavascriptInterface;
use MongoDB\Driver\Command;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\ReadConcern;
use MongoDB\Driver\ReadPreference;
use MongoDB\Driver\Server;
use MongoDB\Driver\Session;
use MongoDB\Driver\WriteConcern;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnexpectedValueException;
use MongoDB\Exception\UnsupportedException;
use MongoDB\MapReduceResult;
use stdClass;
use function assert;
use function current;
use function is_array;
use function is_bool;
use function is_integer;
use function is_object;
use function is_string;
use function MongoDB\create_field_path_type_map;
use function MongoDB\is_mapreduce_output_inline;
use function trigger_error;
use const E_USER_DEPRECATED;

class MapReduce implements Executable
{
    private $databaseName;
    private $collectionName;
    private $map;
    private $reduce;
    private $out;
    private $options;

    public function __construct(string $databaseName, string $collectionName, JavascriptInterface $map, JavascriptInterface $reduce, $out, array $options = [])
    {
        if (!is_string($out) && !is_array($out) && !is_object($out)) {
            throw InvalidArgumentException::invalidType('$out', $out, 'string or array or object');
        }
        if (isset($options['bypassDocumentValidation']) && !is_bool($options['bypassDocumentValidation'])) {
            throw InvalidArgumentException::invalidType('"bypassDocumentValidation" option', $options['bypassDocumentValidation'], 'boolean');
        }
        if (isset($options['collation']) && !is_array($options['collation']) && !is_object($options['collation'])) {
            throw InvalidArgumentException::invalidType('"collation" option', $options['collation'], 'array or object');
        }
        if (isset($options['finalize']) && !$options['finalize'] instanceof JavascriptInterface) {
            throw InvalidArgumentException::invalidType('"finalize" option', $options['finalize'], JavascriptInterface::class);
        }
        if (isset($options['jsMode']) && !is_bool($options['jsMode'])) {
            throw InvalidArgumentException::invalidType('"jsMode" option', $options['jsMode'], 'boolean');
        }
        if (isset($options['limit']) && !is_integer($options['limit'])) {
            throw InvalidArgumentException::invalidType('"limit" option', $options['limit'], 'integer');
        }
        if (isset($options['maxTimeMS']) && !is_integer($options['maxTimeMS'])) {
            throw InvalidArgumentException::invalidType('"maxTimeMS" option', $options['maxTimeMS'], 'integer');
        }
        if (isset($options['query']) && !is_array($options['query']) && !is_object($options['query'])) {
            throw InvalidArgumentException::invalidType('"query" option', $options['query'], 'array or object');
        }
        if (isset($options['readConcern']) && !$options['readConcern'] instanceof ReadConcern) {
            throw InvalidArgumentException::invalidType('"readConcern" option', $options['readConcern'], ReadConcern::class);
        }
        if (isset($options['readPreference']) && !$options['readPreference'] instanceof ReadPreference) {
            throw InvalidArgumentException::invalidType('"readPreference" option', $options['readPreference'], ReadPreference::class);
        }
        if (isset($options['scope']) && !is_array($options['scope']) && !is_object($options['scope'])) {
            throw InvalidArgumentException::invalidType('"scope" option', $options['scope'], 'array or object');
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
        if (isset($options['verbose']) && !is_bool($options['verbose'])) {
            throw InvalidArgumentException::invalidType('"verbose" option', $options['verbose'], 'boolean');
        }
        if (isset($options['writeConcern']) && !$options['writeConcern'] instanceof WriteConcern) {
            throw InvalidArgumentException::invalidType('"writeConcern" option', $options['writeConcern'], WriteConcern::class);
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
        if ($map->getScope() !== null) {
            @trigger_error('Use of Javascript with scope in "$map" argument for MapReduce is deprecated. Put all scope variables in the "scope" option of the MapReduce operation.', E_USER_DEPRECATED);
        }
        if ($reduce->getScope() !== null) {
            @trigger_error('Use of Javascript with scope in "$reduce" argument for MapReduce is deprecated. Put all scope variables in the "scope" option of the MapReduce operation.', E_USER_DEPRECATED);
        }
        if (isset($options['finalize']) && $options['finalize']->getScope() !== null) {
            @trigger_error('Use of Javascript with scope in "finalize" option for MapReduce is deprecated. Put all scope variables in the "scope" option of the MapReduce operation.', E_USER_DEPRECATED);
        }
        $this->checkOutDeprecations($out);
        $this->databaseName = $databaseName;
        $this->collectionName = $collectionName;
        $this->map = $map;
        $this->reduce = $reduce;
        $this->out = $out;
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
        $hasOutputCollection = !is_mapreduce_output_inline($this->out);
        $command = $this->createCommand();
        $options = $this->createOptions($hasOutputCollection);
        $cursor = $hasOutputCollection ? $server->executeReadWriteCommand($this->databaseName, $command, $options) : $server->executeCommand($this->databaseName, $command, $options);
        if (isset($this->options['typeMap']) && !$hasOutputCollection) {
            $cursor->setTypeMap(create_field_path_type_map($this->options['typeMap'], 'results.$'));
        }
        $result = current($cursor->toArray());
        assert($result instanceof stdClass);
        $getIterator = $this->createGetIteratorCallable($result, $server);
        return new MapReduceResult($getIterator, $result);
    }

    private function checkOutDeprecations($out): void
    {
        if (is_string($out)) {
            return;
        }
        $out = (array)$out;
        if (isset($out['nonAtomic']) && !$out['nonAtomic']) {
            @trigger_error('Specifying false for "out.nonAtomic" is deprecated.', E_USER_DEPRECATED);
        }
        if (isset($out['sharded']) && !$out['sharded']) {
            @trigger_error('Specifying false for "out.sharded" is deprecated.', E_USER_DEPRECATED);
        }
    }

    private function createCommand(): Command
    {
        $cmd = ['mapReduce' => $this->collectionName, 'map' => $this->map, 'reduce' => $this->reduce, 'out' => $this->out,];
        foreach (['bypassDocumentValidation', 'comment', 'finalize', 'jsMode', 'limit', 'maxTimeMS', 'verbose'] as $option) {
            if (isset($this->options[$option])) {
                $cmd[$option] = $this->options[$option];
            }
        }
        foreach (['collation', 'query', 'scope', 'sort'] as $option) {
            if (isset($this->options[$option])) {
                $cmd[$option] = (object)$this->options[$option];
            }
        }
        return new Command($cmd);
    }

    private function createGetIteratorCallable(stdClass $result, Server $server): callable
    {
        if (isset($result->results) && is_array($result->results)) {
            $results = $result->results;
            return function () use ($results) {
                return new ArrayIterator($results);
            };
        }
        if (isset($result->result) && (is_string($result->result) || is_object($result->result))) {
            $options = isset($this->options['typeMap']) ? ['typeMap' => $this->options['typeMap']] : [];
            $find = is_string($result->result) ? new Find($this->databaseName, $result->result, [], $options) : new Find($result->result->db, $result->result->collection, [], $options);
            return function () use ($find, $server) {
                return $find->execute($server);
            };
        }
        throw new UnexpectedValueException('mapReduce command did not return inline results or an output collection');
    }

    private function createOptions(bool $hasOutputCollection): array
    {
        $options = [];
        if (isset($this->options['readConcern'])) {
            $options['readConcern'] = $this->options['readConcern'];
        }
        if (!$hasOutputCollection && isset($this->options['readPreference'])) {
            $options['readPreference'] = $this->options['readPreference'];
        }
        if (isset($this->options['session'])) {
            $options['session'] = $this->options['session'];
        }
        if ($hasOutputCollection && isset($this->options['writeConcern'])) {
            $options['writeConcern'] = $this->options['writeConcern'];
        }
        return $options;
    }
}