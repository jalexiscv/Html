<?php

namespace MongoDB\GridFS;

use ArrayIterator;
use MongoDB\Collection;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Manager;
use MongoDB\Driver\ReadPreference;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\UpdateResult;
use MultipleIterator;
use function abs;
use function assert;
use function count;
use function is_numeric;
use function is_object;
use function sprintf;

class CollectionWrapper
{
    private $bucketName;
    private $chunksCollection;
    private $databaseName;
    private $checkedIndexes = false;
    private $filesCollection;

    public function __construct(Manager $manager, string $databaseName, string $bucketName, array $collectionOptions = [])
    {
        $this->databaseName = $databaseName;
        $this->bucketName = $bucketName;
        $this->filesCollection = new Collection($manager, $databaseName, sprintf('%s.files', $bucketName), $collectionOptions);
        $this->chunksCollection = new Collection($manager, $databaseName, sprintf('%s.chunks', $bucketName), $collectionOptions);
    }

    public function deleteChunksByFilesId($id): void
    {
        $this->chunksCollection->deleteMany(['files_id' => $id]);
    }

    public function deleteFileAndChunksById($id): void
    {
        $this->filesCollection->deleteOne(['_id' => $id]);
        $this->chunksCollection->deleteMany(['files_id' => $id]);
    }

    public function dropCollections(): void
    {
        $this->filesCollection->drop(['typeMap' => []]);
        $this->chunksCollection->drop(['typeMap' => []]);
    }

    public function findChunksByFileId($id, int $fromChunk = 0): Cursor
    {
        return $this->chunksCollection->find(['files_id' => $id, 'n' => ['$gte' => $fromChunk],], ['sort' => ['n' => 1], 'typeMap' => ['root' => 'stdClass'],]);
    }

    public function findFileByFilenameAndRevision(string $filename, int $revision): ?object
    {
        $filename = $filename;
        $revision = $revision;
        if ($revision < 0) {
            $skip = abs($revision) - 1;
            $sortOrder = -1;
        } else {
            $skip = $revision;
            $sortOrder = 1;
        }
        $file = $this->filesCollection->findOne(['filename' => $filename], ['skip' => $skip, 'sort' => ['uploadDate' => $sortOrder], 'typeMap' => ['root' => 'stdClass'],]);
        assert(is_object($file) || $file === null);
        return $file;
    }

    public function findFileById($id): ?object
    {
        $file = $this->filesCollection->findOne(['_id' => $id], ['typeMap' => ['root' => 'stdClass']]);
        assert(is_object($file) || $file === null);
        return $file;
    }

    public function findFiles($filter, array $options = [])
    {
        return $this->filesCollection->find($filter, $options);
    }

    public function findOneFile($filter, array $options = [])
    {
        return $this->filesCollection->findOne($filter, $options);
    }

    public function getBucketName(): string
    {
        return $this->bucketName;
    }

    public function getChunksCollection(): Collection
    {
        return $this->chunksCollection;
    }

    public function getDatabaseName(): string
    {
        return $this->databaseName;
    }

    public function getFilesCollection(): Collection
    {
        return $this->filesCollection;
    }

    public function insertChunk($chunk): void
    {
        if (!$this->checkedIndexes) {
            $this->ensureIndexes();
        }
        $this->chunksCollection->insertOne($chunk);
    }

    public function insertFile($file): void
    {
        if (!$this->checkedIndexes) {
            $this->ensureIndexes();
        }
        $this->filesCollection->insertOne($file);
    }

    public function updateFilenameForId($id, string $filename): UpdateResult
    {
        return $this->filesCollection->updateOne(['_id' => $id], ['$set' => ['filename' => $filename]]);
    }

    private function ensureChunksIndex(): void
    {
        $expectedIndex = ['files_id' => 1, 'n' => 1];
        foreach ($this->chunksCollection->listIndexes() as $index) {
            if ($index->isUnique() && $this->indexKeysMatch($expectedIndex, $index->getKey())) {
                return;
            }
        }
        $this->chunksCollection->createIndex($expectedIndex, ['unique' => true]);
    }

    private function ensureFilesIndex(): void
    {
        $expectedIndex = ['filename' => 1, 'uploadDate' => 1];
        foreach ($this->filesCollection->listIndexes() as $index) {
            if ($this->indexKeysMatch($expectedIndex, $index->getKey())) {
                return;
            }
        }
        $this->filesCollection->createIndex($expectedIndex);
    }

    private function ensureIndexes(): void
    {
        if ($this->checkedIndexes) {
            return;
        }
        $this->checkedIndexes = true;
        if (!$this->isFilesCollectionEmpty()) {
            return;
        }
        $this->ensureFilesIndex();
        $this->ensureChunksIndex();
    }

    private function indexKeysMatch(array $expectedKeys, array $actualKeys): bool
    {
        if (count($expectedKeys) !== count($actualKeys)) {
            return false;
        }
        $iterator = new MultipleIterator(MultipleIterator::MIT_NEED_ANY);
        $iterator->attachIterator(new ArrayIterator($expectedKeys));
        $iterator->attachIterator(new ArrayIterator($actualKeys));
        foreach ($iterator as $key => $value) {
            [$expectedKey, $actualKey] = $key;
            [$expectedValue, $actualValue] = $value;
            if ($expectedKey !== $actualKey) {
                return false;
            }
            if (!is_numeric($actualValue) || (int)$expectedValue !== (int)$actualValue) {
                return false;
            }
        }
        return true;
    }

    private function isFilesCollectionEmpty(): bool
    {
        return null === $this->filesCollection->findOne([], ['readPreference' => new ReadPreference(ReadPreference::RP_PRIMARY), 'projection' => ['_id' => 1], 'typeMap' => [],]);
    }
}