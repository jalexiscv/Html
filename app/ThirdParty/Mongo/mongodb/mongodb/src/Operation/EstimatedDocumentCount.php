<?php

namespace MongoDB\Operation;

use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\ReadConcern;
use MongoDB\Driver\ReadPreference;
use MongoDB\Driver\Server;
use MongoDB\Driver\Session;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnexpectedValueException;
use MongoDB\Exception\UnsupportedException;
use function array_intersect_key;
use function is_integer;

class EstimatedDocumentCount implements Executable, Explainable
{
    private $databaseName;
    private $collectionName;
    private $options;
    private static $errorCodeCollectionNotFound = 26;
    private static $wireVersionForCollStats = 12;

    public function __construct(string $databaseName, string $collectionName, array $options = [])
    {
        $this->databaseName = $databaseName;
        $this->collectionName = $collectionName;
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
        $this->options = array_intersect_key($options, ['comment' => 1, 'maxTimeMS' => 1, 'readConcern' => 1, 'readPreference' => 1, 'session' => 1]);
    }

    public function execute(Server $server)
    {
        return $this->createCount()->execute($server);
    }

    public function getCommandDocument(Server $server)
    {
        return $this->createCount()->getCommandDocument($server);
    }

    private function createCount(): Count
    {
        return new Count($this->databaseName, $this->collectionName, [], $this->options);
    }
}