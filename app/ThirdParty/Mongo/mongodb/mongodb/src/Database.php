<?php

namespace MongoDB;

use Iterator;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Manager;
use MongoDB\Driver\ReadConcern;
use MongoDB\Driver\ReadPreference;
use MongoDB\Driver\WriteConcern;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnexpectedValueException;
use MongoDB\Exception\UnsupportedException;
use MongoDB\GridFS\Bucket;
use MongoDB\Model\BSONArray;
use MongoDB\Model\BSONDocument;
use MongoDB\Model\CollectionInfoIterator;
use MongoDB\Operation\Aggregate;
use MongoDB\Operation\CreateCollection;
use MongoDB\Operation\CreateIndexes;
use MongoDB\Operation\DatabaseCommand;
use MongoDB\Operation\DropCollection;
use MongoDB\Operation\DropDatabase;
use MongoDB\Operation\ListCollectionNames;
use MongoDB\Operation\ListCollections;
use MongoDB\Operation\ModifyCollection;
use MongoDB\Operation\RenameCollection;
use MongoDB\Operation\Watch;
use Traversable;
use function is_array;
use function strlen;

class Database
{
    private static $defaultTypeMap = ['array' => BSONArray::class, 'document' => BSONDocument::class, 'root' => BSONDocument::class,];
    private static $wireVersionForReadConcernWithWriteStage = 8;
    private $databaseName;
    private $manager;
    private $readConcern;
    private $readPreference;
    private $typeMap;
    private $writeConcern;

    public function __construct(Manager $manager, string $databaseName, array $options = [])
    {
        if (strlen($databaseName) < 1) {
            throw new InvalidArgumentException('$databaseName is invalid: ' . $databaseName);
        }
        if (isset($options['readConcern']) && !$options['readConcern'] instanceof ReadConcern) {
            throw InvalidArgumentException::invalidType('"readConcern" option', $options['readConcern'], ReadConcern::class);
        }
        if (isset($options['readPreference']) && !$options['readPreference'] instanceof ReadPreference) {
            throw InvalidArgumentException::invalidType('"readPreference" option', $options['readPreference'], ReadPreference::class);
        }
        if (isset($options['typeMap']) && !is_array($options['typeMap'])) {
            throw InvalidArgumentException::invalidType('"typeMap" option', $options['typeMap'], 'array');
        }
        if (isset($options['writeConcern']) && !$options['writeConcern'] instanceof WriteConcern) {
            throw InvalidArgumentException::invalidType('"writeConcern" option', $options['writeConcern'], WriteConcern::class);
        }
        $this->manager = $manager;
        $this->databaseName = $databaseName;
        $this->readConcern = $options['readConcern'] ?? $this->manager->getReadConcern();
        $this->readPreference = $options['readPreference'] ?? $this->manager->getReadPreference();
        $this->typeMap = $options['typeMap'] ?? self::$defaultTypeMap;
        $this->writeConcern = $options['writeConcern'] ?? $this->manager->getWriteConcern();
    }

    public function __debugInfo()
    {
        return ['databaseName' => $this->databaseName, 'manager' => $this->manager, 'readConcern' => $this->readConcern, 'readPreference' => $this->readPreference, 'typeMap' => $this->typeMap, 'writeConcern' => $this->writeConcern,];
    }

    public function __get(string $collectionName)
    {
        return $this->selectCollection($collectionName);
    }

    public function __toString()
    {
        return $this->databaseName;
    }

    public function aggregate(array $pipeline, array $options = [])
    {
        $hasWriteStage = is_last_pipeline_operator_write($pipeline);
        if (!isset($options['readPreference']) && !is_in_transaction($options)) {
            $options['readPreference'] = $this->readPreference;
        }
        $server = $hasWriteStage ? select_server_for_aggregate_write_stage($this->manager, $options) : select_server($this->manager, $options);
        if (!isset($options['readConcern']) && !is_in_transaction($options) && (!$hasWriteStage || server_supports_feature($server, self::$wireVersionForReadConcernWithWriteStage))) {
            $options['readConcern'] = $this->readConcern;
        }
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->typeMap;
        }
        if ($hasWriteStage && !isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $operation = new Aggregate($this->databaseName, null, $pipeline, $options);
        return $operation->execute($server);
    }

    public function command($command, array $options = [])
    {
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->typeMap;
        }
        $operation = new DatabaseCommand($this->databaseName, $command, $options);
        $server = select_server($this->manager, $options);
        return $operation->execute($server);
    }

    public function createCollection(string $collectionName, array $options = [])
    {
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->typeMap;
        }
        $server = select_server($this->manager, $options);
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $encryptedFields = $options['encryptedFields'] ?? get_encrypted_fields_from_driver($this->databaseName, $collectionName, $this->manager) ?? null;
        if ($encryptedFields !== null) {
            $options['encryptedFields'] = $encryptedFields;
            $encryptedFields = (array)$encryptedFields;
            $enxcolOptions = ['clusteredIndex' => ['key' => ['_id' => 1], 'unique' => true]];
            (new CreateCollection($this->databaseName, $encryptedFields['escCollection'] ?? 'enxcol_.' . $collectionName . '.esc', $enxcolOptions))->execute($server);
            (new CreateCollection($this->databaseName, $encryptedFields['eccCollection'] ?? 'enxcol_.' . $collectionName . '.ecc', $enxcolOptions))->execute($server);
            (new CreateCollection($this->databaseName, $encryptedFields['ecocCollection'] ?? 'enxcol_.' . $collectionName . '.ecoc', $enxcolOptions))->execute($server);
        }
        $operation = new CreateCollection($this->databaseName, $collectionName, $options);
        $result = $operation->execute($server);
        if ($encryptedFields !== null) {
            (new CreateIndexes($this->databaseName, $collectionName, [['key' => ['__safeContent__' => 1]]]))->execute($server);
        }
        return $result;
    }

    public function drop(array $options = [])
    {
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->typeMap;
        }
        $server = select_server($this->manager, $options);
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $operation = new DropDatabase($this->databaseName, $options);
        return $operation->execute($server);
    }

    public function dropCollection(string $collectionName, array $options = [])
    {
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->typeMap;
        }
        $server = select_server($this->manager, $options);
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $encryptedFields = $options['encryptedFields'] ?? get_encrypted_fields_from_driver($this->databaseName, $collectionName, $this->manager) ?? get_encrypted_fields_from_server($this->databaseName, $collectionName, $this->manager, $server) ?? null;
        if ($encryptedFields !== null) {
            unset($options['encryptedFields']);
            $encryptedFields = (array)$encryptedFields;
            (new DropCollection($this->databaseName, $encryptedFields['escCollection'] ?? 'enxcol_.' . $collectionName . '.esc'))->execute($server);
            (new DropCollection($this->databaseName, $encryptedFields['eccCollection'] ?? 'enxcol_.' . $collectionName . '.ecc'))->execute($server);
            (new DropCollection($this->databaseName, $encryptedFields['ecocCollection'] ?? 'enxcol_.' . $collectionName . '.ecoc'))->execute($server);
        }
        $operation = new DropCollection($this->databaseName, $collectionName, $options);
        return $operation->execute($server);
    }

    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    public function getManager()
    {
        return $this->manager;
    }

    public function getReadConcern()
    {
        return $this->readConcern;
    }

    public function getReadPreference()
    {
        return $this->readPreference;
    }

    public function getTypeMap()
    {
        return $this->typeMap;
    }

    public function getWriteConcern()
    {
        return $this->writeConcern;
    }

    public function listCollectionNames(array $options = []): Iterator
    {
        $operation = new ListCollectionNames($this->databaseName, $options);
        $server = select_server($this->manager, $options);
        return $operation->execute($server);
    }

    public function listCollections(array $options = [])
    {
        $operation = new ListCollections($this->databaseName, $options);
        $server = select_server($this->manager, $options);
        return $operation->execute($server);
    }

    public function modifyCollection(string $collectionName, array $collectionOptions, array $options = [])
    {
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->typeMap;
        }
        $server = select_server($this->manager, $options);
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $operation = new ModifyCollection($this->databaseName, $collectionName, $collectionOptions, $options);
        return $operation->execute($server);
    }

    public function renameCollection(string $fromCollectionName, string $toCollectionName, ?string $toDatabaseName = null, array $options = [])
    {
        if (!isset($toDatabaseName)) {
            $toDatabaseName = $this->databaseName;
        }
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->typeMap;
        }
        $server = select_server($this->manager, $options);
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $operation = new RenameCollection($this->databaseName, $fromCollectionName, $toDatabaseName, $toCollectionName, $options);
        return $operation->execute($server);
    }

    public function selectCollection(string $collectionName, array $options = [])
    {
        $options += ['readConcern' => $this->readConcern, 'readPreference' => $this->readPreference, 'typeMap' => $this->typeMap, 'writeConcern' => $this->writeConcern,];
        return new Collection($this->manager, $this->databaseName, $collectionName, $options);
    }

    public function selectGridFSBucket(array $options = [])
    {
        $options += ['readConcern' => $this->readConcern, 'readPreference' => $this->readPreference, 'typeMap' => $this->typeMap, 'writeConcern' => $this->writeConcern,];
        return new Bucket($this->manager, $this->databaseName, $options);
    }

    public function watch(array $pipeline = [], array $options = [])
    {
        if (!isset($options['readPreference']) && !is_in_transaction($options)) {
            $options['readPreference'] = $this->readPreference;
        }
        $server = select_server($this->manager, $options);
        if (!isset($options['readConcern']) && !is_in_transaction($options)) {
            $options['readConcern'] = $this->readConcern;
        }
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->typeMap;
        }
        $operation = new Watch($this->manager, $this->databaseName, null, $pipeline, $options);
        return $operation->execute($server);
    }

    public function withOptions(array $options = [])
    {
        $options += ['readConcern' => $this->readConcern, 'readPreference' => $this->readPreference, 'typeMap' => $this->typeMap, 'writeConcern' => $this->writeConcern,];
        return new Database($this->manager, $this->databaseName, $options);
    }
}