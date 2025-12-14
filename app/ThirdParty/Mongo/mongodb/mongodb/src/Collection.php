<?php

namespace MongoDB;

use MongoDB\BSON\JavascriptInterface;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Manager;
use MongoDB\Driver\ReadConcern;
use MongoDB\Driver\ReadPreference;
use MongoDB\Driver\WriteConcern;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnexpectedValueException;
use MongoDB\Exception\UnsupportedException;
use MongoDB\Model\BSONArray;
use MongoDB\Model\BSONDocument;
use MongoDB\Model\IndexInfo;
use MongoDB\Model\IndexInfoIterator;
use MongoDB\Operation\Aggregate;
use MongoDB\Operation\BulkWrite;
use MongoDB\Operation\Count;
use MongoDB\Operation\CountDocuments;
use MongoDB\Operation\CreateIndexes;
use MongoDB\Operation\DeleteMany;
use MongoDB\Operation\DeleteOne;
use MongoDB\Operation\Distinct;
use MongoDB\Operation\DropCollection;
use MongoDB\Operation\DropIndexes;
use MongoDB\Operation\EstimatedDocumentCount;
use MongoDB\Operation\Explain;
use MongoDB\Operation\Explainable;
use MongoDB\Operation\Find;
use MongoDB\Operation\FindOne;
use MongoDB\Operation\FindOneAndDelete;
use MongoDB\Operation\FindOneAndReplace;
use MongoDB\Operation\FindOneAndUpdate;
use MongoDB\Operation\InsertMany;
use MongoDB\Operation\InsertOne;
use MongoDB\Operation\ListIndexes;
use MongoDB\Operation\MapReduce;
use MongoDB\Operation\RenameCollection;
use MongoDB\Operation\ReplaceOne;
use MongoDB\Operation\UpdateMany;
use MongoDB\Operation\UpdateOne;
use MongoDB\Operation\Watch;
use Traversable;
use function array_diff_key;
use function array_intersect_key;
use function current;
use function is_array;
use function strlen;

class Collection
{
    private static $defaultTypeMap = ['array' => BSONArray::class, 'document' => BSONDocument::class, 'root' => BSONDocument::class,];
    private static $wireVersionForReadConcernWithWriteStage = 8;
    private $collectionName;
    private $databaseName;
    private $manager;
    private $readConcern;
    private $readPreference;
    private $typeMap;
    private $writeConcern;

    public function __construct(Manager $manager, string $databaseName, string $collectionName, array $options = [])
    {
        if (strlen($databaseName) < 1) {
            throw new InvalidArgumentException('$databaseName is invalid: ' . $databaseName);
        }
        if (strlen($collectionName) < 1) {
            throw new InvalidArgumentException('$collectionName is invalid: ' . $collectionName);
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
        $this->collectionName = $collectionName;
        $this->readConcern = $options['readConcern'] ?? $this->manager->getReadConcern();
        $this->readPreference = $options['readPreference'] ?? $this->manager->getReadPreference();
        $this->typeMap = $options['typeMap'] ?? self::$defaultTypeMap;
        $this->writeConcern = $options['writeConcern'] ?? $this->manager->getWriteConcern();
    }

    public function __debugInfo()
    {
        return ['collectionName' => $this->collectionName, 'databaseName' => $this->databaseName, 'manager' => $this->manager, 'readConcern' => $this->readConcern, 'readPreference' => $this->readPreference, 'typeMap' => $this->typeMap, 'writeConcern' => $this->writeConcern,];
    }

    public function __toString()
    {
        return $this->databaseName . '.' . $this->collectionName;
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
        $operation = new Aggregate($this->databaseName, $this->collectionName, $pipeline, $options);
        return $operation->execute($server);
    }

    public function bulkWrite(array $operations, array $options = [])
    {
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $operation = new BulkWrite($this->databaseName, $this->collectionName, $operations, $options);
        $server = select_server($this->manager, $options);
        return $operation->execute($server);
    }

    public function count($filter = [], array $options = [])
    {
        if (!isset($options['readPreference']) && !is_in_transaction($options)) {
            $options['readPreference'] = $this->readPreference;
        }
        $server = select_server($this->manager, $options);
        if (!isset($options['readConcern']) && !is_in_transaction($options)) {
            $options['readConcern'] = $this->readConcern;
        }
        $operation = new Count($this->databaseName, $this->collectionName, $filter, $options);
        return $operation->execute($server);
    }

    public function countDocuments($filter = [], array $options = [])
    {
        if (!isset($options['readPreference']) && !is_in_transaction($options)) {
            $options['readPreference'] = $this->readPreference;
        }
        $server = select_server($this->manager, $options);
        if (!isset($options['readConcern']) && !is_in_transaction($options)) {
            $options['readConcern'] = $this->readConcern;
        }
        $operation = new CountDocuments($this->databaseName, $this->collectionName, $filter, $options);
        return $operation->execute($server);
    }

    public function createIndex($key, array $options = [])
    {
        $commandOptionKeys = ['commitQuorum' => 1, 'maxTimeMS' => 1, 'session' => 1, 'writeConcern' => 1];
        $indexOptions = array_diff_key($options, $commandOptionKeys);
        $commandOptions = array_intersect_key($options, $commandOptionKeys);
        return current($this->createIndexes([['key' => $key] + $indexOptions], $commandOptions));
    }

    public function createIndexes(array $indexes, array $options = [])
    {
        $server = select_server($this->manager, $options);
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $operation = new CreateIndexes($this->databaseName, $this->collectionName, $indexes, $options);
        return $operation->execute($server);
    }

    public function deleteMany($filter, array $options = [])
    {
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $operation = new DeleteMany($this->databaseName, $this->collectionName, $filter, $options);
        $server = select_server($this->manager, $options);
        return $operation->execute($server);
    }

    public function deleteOne($filter, array $options = [])
    {
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $operation = new DeleteOne($this->databaseName, $this->collectionName, $filter, $options);
        $server = select_server($this->manager, $options);
        return $operation->execute($server);
    }

    public function distinct(string $fieldName, $filter = [], array $options = [])
    {
        if (!isset($options['readPreference']) && !is_in_transaction($options)) {
            $options['readPreference'] = $this->readPreference;
        }
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->typeMap;
        }
        $server = select_server($this->manager, $options);
        if (!isset($options['readConcern']) && !is_in_transaction($options)) {
            $options['readConcern'] = $this->readConcern;
        }
        $operation = new Distinct($this->databaseName, $this->collectionName, $fieldName, $filter, $options);
        return $operation->execute($server);
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
        $encryptedFields = $options['encryptedFields'] ?? get_encrypted_fields_from_driver($this->databaseName, $this->collectionName, $this->manager) ?? get_encrypted_fields_from_server($this->databaseName, $this->collectionName, $this->manager, $server) ?? null;
        if ($encryptedFields !== null) {
            unset($options['encryptedFields']);
            $encryptedFields = (array)$encryptedFields;
            (new DropCollection($this->databaseName, $encryptedFields['escCollection'] ?? 'enxcol_.' . $this->collectionName . '.esc'))->execute($server);
            (new DropCollection($this->databaseName, $encryptedFields['eccCollection'] ?? 'enxcol_.' . $this->collectionName . '.ecc'))->execute($server);
            (new DropCollection($this->databaseName, $encryptedFields['ecocCollection'] ?? 'enxcol_.' . $this->collectionName . '.ecoc'))->execute($server);
        }
        $operation = new DropCollection($this->databaseName, $this->collectionName, $options);
        return $operation->execute($server);
    }

    public function dropIndex($indexName, array $options = [])
    {
        $indexName = (string)$indexName;
        if ($indexName === '*') {
            throw new InvalidArgumentException('dropIndexes() must be used to drop multiple indexes');
        }
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->typeMap;
        }
        $server = select_server($this->manager, $options);
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $operation = new DropIndexes($this->databaseName, $this->collectionName, $indexName, $options);
        return $operation->execute($server);
    }

    public function dropIndexes(array $options = [])
    {
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->typeMap;
        }
        $server = select_server($this->manager, $options);
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $operation = new DropIndexes($this->databaseName, $this->collectionName, '*', $options);
        return $operation->execute($server);
    }

    public function estimatedDocumentCount(array $options = [])
    {
        if (!isset($options['readPreference']) && !is_in_transaction($options)) {
            $options['readPreference'] = $this->readPreference;
        }
        $server = select_server($this->manager, $options);
        if (!isset($options['readConcern']) && !is_in_transaction($options)) {
            $options['readConcern'] = $this->readConcern;
        }
        $operation = new EstimatedDocumentCount($this->databaseName, $this->collectionName, $options);
        return $operation->execute($server);
    }

    public function explain(Explainable $explainable, array $options = [])
    {
        if (!isset($options['readPreference']) && !is_in_transaction($options)) {
            $options['readPreference'] = $this->readPreference;
        }
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->typeMap;
        }
        $server = select_server($this->manager, $options);
        $operation = new Explain($this->databaseName, $explainable, $options);
        return $operation->execute($server);
    }

    public function find($filter = [], array $options = [])
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
        $operation = new Find($this->databaseName, $this->collectionName, $filter, $options);
        return $operation->execute($server);
    }

    public function findOne($filter = [], array $options = [])
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
        $operation = new FindOne($this->databaseName, $this->collectionName, $filter, $options);
        return $operation->execute($server);
    }

    public function findOneAndDelete($filter, array $options = [])
    {
        $server = select_server($this->manager, $options);
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->typeMap;
        }
        $operation = new FindOneAndDelete($this->databaseName, $this->collectionName, $filter, $options);
        return $operation->execute($server);
    }

    public function findOneAndReplace($filter, $replacement, array $options = [])
    {
        $server = select_server($this->manager, $options);
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->typeMap;
        }
        $operation = new FindOneAndReplace($this->databaseName, $this->collectionName, $filter, $replacement, $options);
        return $operation->execute($server);
    }

    public function findOneAndUpdate($filter, $update, array $options = [])
    {
        $server = select_server($this->manager, $options);
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->typeMap;
        }
        $operation = new FindOneAndUpdate($this->databaseName, $this->collectionName, $filter, $update, $options);
        return $operation->execute($server);
    }

    public function getCollectionName()
    {
        return $this->collectionName;
    }

    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    public function getManager()
    {
        return $this->manager;
    }

    public function getNamespace()
    {
        return $this->databaseName . '.' . $this->collectionName;
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

    public function insertMany(array $documents, array $options = [])
    {
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $operation = new InsertMany($this->databaseName, $this->collectionName, $documents, $options);
        $server = select_server($this->manager, $options);
        return $operation->execute($server);
    }

    public function insertOne($document, array $options = [])
    {
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $operation = new InsertOne($this->databaseName, $this->collectionName, $document, $options);
        $server = select_server($this->manager, $options);
        return $operation->execute($server);
    }

    public function listIndexes(array $options = [])
    {
        $operation = new ListIndexes($this->databaseName, $this->collectionName, $options);
        $server = select_server($this->manager, $options);
        return $operation->execute($server);
    }

    public function mapReduce(JavascriptInterface $map, JavascriptInterface $reduce, $out, array $options = [])
    {
        $hasOutputCollection = !is_mapreduce_output_inline($out);
        if (!isset($options['readPreference']) && !is_in_transaction($options)) {
            $options['readPreference'] = $this->readPreference;
        }
        if ($hasOutputCollection) {
            $options['readPreference'] = new ReadPreference(ReadPreference::RP_PRIMARY);
        }
        $server = select_server($this->manager, $options);
        if (!isset($options['readConcern']) && !($hasOutputCollection && $this->readConcern->getLevel() === ReadConcern::MAJORITY) && !is_in_transaction($options)) {
            $options['readConcern'] = $this->readConcern;
        }
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->typeMap;
        }
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $operation = new MapReduce($this->databaseName, $this->collectionName, $map, $reduce, $out, $options);
        return $operation->execute($server);
    }

    public function rename(string $toCollectionName, ?string $toDatabaseName = null, array $options = [])
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
        $operation = new RenameCollection($this->databaseName, $this->collectionName, $toDatabaseName, $toCollectionName, $options);
        return $operation->execute($server);
    }

    public function replaceOne($filter, $replacement, array $options = [])
    {
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $operation = new ReplaceOne($this->databaseName, $this->collectionName, $filter, $replacement, $options);
        $server = select_server($this->manager, $options);
        return $operation->execute($server);
    }

    public function updateMany($filter, $update, array $options = [])
    {
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $operation = new UpdateMany($this->databaseName, $this->collectionName, $filter, $update, $options);
        $server = select_server($this->manager, $options);
        return $operation->execute($server);
    }

    public function updateOne($filter, $update, array $options = [])
    {
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $operation = new UpdateOne($this->databaseName, $this->collectionName, $filter, $update, $options);
        $server = select_server($this->manager, $options);
        return $operation->execute($server);
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
        $operation = new Watch($this->manager, $this->databaseName, $this->collectionName, $pipeline, $options);
        return $operation->execute($server);
    }

    public function withOptions(array $options = [])
    {
        $options += ['readConcern' => $this->readConcern, 'readPreference' => $this->readPreference, 'typeMap' => $this->typeMap, 'writeConcern' => $this->writeConcern,];
        return new Collection($this->manager, $this->databaseName, $this->collectionName, $options);
    }
}