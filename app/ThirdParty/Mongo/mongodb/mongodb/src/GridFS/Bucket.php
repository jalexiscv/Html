<?php

namespace MongoDB\GridFS;

use MongoDB\Collection;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Manager;
use MongoDB\Driver\ReadConcern;
use MongoDB\Driver\ReadPreference;
use MongoDB\Driver\WriteConcern;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnsupportedException;
use MongoDB\GridFS\Exception\CorruptFileException;
use MongoDB\GridFS\Exception\FileNotFoundException;
use MongoDB\GridFS\Exception\StreamException;
use MongoDB\Model\BSONArray;
use MongoDB\Model\BSONDocument;
use MongoDB\Operation\Find;
use function array_intersect_key;
use function assert;
use function fopen;
use function get_resource_type;
use function in_array;
use function is_array;
use function is_bool;
use function is_integer;
use function is_object;
use function is_resource;
use function is_string;
use function method_exists;
use function MongoDB\apply_type_map_to_document;
use function MongoDB\BSON\fromPHP;
use function MongoDB\BSON\toJSON;
use function property_exists;
use function sprintf;
use function stream_context_create;
use function stream_copy_to_stream;
use function stream_get_meta_data;
use function stream_get_wrappers;
use function urlencode;

class Bucket
{
    private static $defaultBucketName = 'fs';
    private static $defaultChunkSizeBytes = 261120;
    private static $defaultTypeMap = ['array' => BSONArray::class, 'document' => BSONDocument::class, 'root' => BSONDocument::class,];
    private static $streamWrapperProtocol = 'gridfs';
    private $collectionWrapper;
    private $databaseName;
    private $manager;
    private $bucketName;
    private $disableMD5;
    private $chunkSizeBytes;
    private $readConcern;
    private $readPreference;
    private $typeMap;
    private $writeConcern;

    public function __construct(Manager $manager, string $databaseName, array $options = [])
    {
        $options += ['bucketName' => self::$defaultBucketName, 'chunkSizeBytes' => self::$defaultChunkSizeBytes, 'disableMD5' => false,];
        if (!is_string($options['bucketName'])) {
            throw InvalidArgumentException::invalidType('"bucketName" option', $options['bucketName'], 'string');
        }
        if (!is_integer($options['chunkSizeBytes'])) {
            throw InvalidArgumentException::invalidType('"chunkSizeBytes" option', $options['chunkSizeBytes'], 'integer');
        }
        if ($options['chunkSizeBytes'] < 1) {
            throw new InvalidArgumentException(sprintf('Expected "chunkSizeBytes" option to be >= 1, %d given', $options['chunkSizeBytes']));
        }
        if (!is_bool($options['disableMD5'])) {
            throw InvalidArgumentException::invalidType('"disableMD5" option', $options['disableMD5'], 'boolean');
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
        $this->bucketName = $options['bucketName'];
        $this->chunkSizeBytes = $options['chunkSizeBytes'];
        $this->disableMD5 = $options['disableMD5'];
        $this->readConcern = $options['readConcern'] ?? $this->manager->getReadConcern();
        $this->readPreference = $options['readPreference'] ?? $this->manager->getReadPreference();
        $this->typeMap = $options['typeMap'] ?? self::$defaultTypeMap;
        $this->writeConcern = $options['writeConcern'] ?? $this->manager->getWriteConcern();
        $collectionOptions = array_intersect_key($options, ['readConcern' => 1, 'readPreference' => 1, 'typeMap' => 1, 'writeConcern' => 1]);
        $this->collectionWrapper = new CollectionWrapper($manager, $databaseName, $options['bucketName'], $collectionOptions);
        $this->registerStreamWrapper();
    }

    public function __debugInfo()
    {
        return ['bucketName' => $this->bucketName, 'databaseName' => $this->databaseName, 'manager' => $this->manager, 'chunkSizeBytes' => $this->chunkSizeBytes, 'readConcern' => $this->readConcern, 'readPreference' => $this->readPreference, 'typeMap' => $this->typeMap, 'writeConcern' => $this->writeConcern,];
    }

    public function delete($id)
    {
        $file = $this->collectionWrapper->findFileById($id);
        $this->collectionWrapper->deleteFileAndChunksById($id);
        if ($file === null) {
            throw FileNotFoundException::byId($id, $this->getFilesNamespace());
        }
    }

    public function downloadToStream($id, $destination)
    {
        if (!is_resource($destination) || get_resource_type($destination) != "stream") {
            throw InvalidArgumentException::invalidType('$destination', $destination, 'resource');
        }
        $source = $this->openDownloadStream($id);
        if (@stream_copy_to_stream($source, $destination) === false) {
            throw StreamException::downloadFromIdFailed($id, $source, $destination);
        }
    }

    public function downloadToStreamByName(string $filename, $destination, array $options = [])
    {
        if (!is_resource($destination) || get_resource_type($destination) != "stream") {
            throw InvalidArgumentException::invalidType('$destination', $destination, 'resource');
        }
        $source = $this->openDownloadStreamByName($filename, $options);
        if (@stream_copy_to_stream($source, $destination) === false) {
            throw StreamException::downloadFromFilenameFailed($filename, $source, $destination);
        }
    }

    public function drop()
    {
        $this->collectionWrapper->dropCollections();
    }

    public function find($filter = [], array $options = [])
    {
        return $this->collectionWrapper->findFiles($filter, $options);
    }

    public function findOne($filter = [], array $options = [])
    {
        return $this->collectionWrapper->findOneFile($filter, $options);
    }

    public function getBucketName()
    {
        return $this->bucketName;
    }

    public function getChunksCollection()
    {
        return $this->collectionWrapper->getChunksCollection();
    }

    public function getChunkSizeBytes()
    {
        return $this->chunkSizeBytes;
    }

    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    public function getFileDocumentForStream($stream)
    {
        $file = $this->getRawFileDocumentForStream($stream);
        return apply_type_map_to_document($file, $this->typeMap);
    }

    public function getFileIdForStream($stream)
    {
        $file = $this->getRawFileDocumentForStream($stream);
        $typeMap = ['root' => 'stdClass'] + $this->typeMap;
        $file = apply_type_map_to_document($file, $typeMap);
        assert(is_object($file));
        if (!isset($file->_id) && !property_exists($file, '_id')) {
            throw new CorruptFileException('file._id does not exist');
        }
        return $file->_id;
    }

    public function getFilesCollection()
    {
        return $this->collectionWrapper->getFilesCollection();
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

    public function openDownloadStream($id)
    {
        $file = $this->collectionWrapper->findFileById($id);
        if ($file === null) {
            throw FileNotFoundException::byId($id, $this->getFilesNamespace());
        }
        return $this->openDownloadStreamByFile($file);
    }

    public function openDownloadStreamByName(string $filename, array $options = [])
    {
        $options += ['revision' => -1];
        $file = $this->collectionWrapper->findFileByFilenameAndRevision($filename, $options['revision']);
        if ($file === null) {
            throw FileNotFoundException::byFilenameAndRevision($filename, $options['revision'], $this->getFilesNamespace());
        }
        return $this->openDownloadStreamByFile($file);
    }

    public function openUploadStream(string $filename, array $options = [])
    {
        $options += ['chunkSizeBytes' => $this->chunkSizeBytes];
        $path = $this->createPathForUpload();
        $context = stream_context_create([self::$streamWrapperProtocol => ['collectionWrapper' => $this->collectionWrapper, 'filename' => $filename, 'options' => $options,],]);
        return fopen($path, 'w', false, $context);
    }

    public function rename($id, string $newFilename)
    {
        $updateResult = $this->collectionWrapper->updateFilenameForId($id, $newFilename);
        if ($updateResult->getModifiedCount() === 1) {
            return;
        }
        $found = $updateResult->getMatchedCount() !== null ? $updateResult->getMatchedCount() === 1 : $this->collectionWrapper->findFileById($id) !== null;
        if (!$found) {
            throw FileNotFoundException::byId($id, $this->getFilesNamespace());
        }
    }

    public function uploadFromStream(string $filename, $source, array $options = [])
    {
        if (!is_resource($source) || get_resource_type($source) != "stream") {
            throw InvalidArgumentException::invalidType('$source', $source, 'resource');
        }
        $destination = $this->openUploadStream($filename, $options);
        if (@stream_copy_to_stream($source, $destination) === false) {
            $destinationUri = $this->createPathForFile($this->getRawFileDocumentForStream($destination));
            throw StreamException::uploadFailed($filename, $source, $destinationUri);
        }
        return $this->getFileIdForStream($destination);
    }

    private function createPathForFile(object $file): string
    {
        if (is_array($file->_id) || (is_object($file->_id) && !method_exists($file->_id, '__toString'))) {
            $id = toJSON(fromPHP(['_id' => $file->_id]));
        } else {
            $id = (string)$file->_id;
        }
        return sprintf('%s://%s/%s.files/%s', self::$streamWrapperProtocol, urlencode($this->databaseName), urlencode($this->bucketName), urlencode($id));
    }

    private function createPathForUpload(): string
    {
        return sprintf('%s://%s/%s.files', self::$streamWrapperProtocol, urlencode($this->databaseName), urlencode($this->bucketName));
    }

    private function getFilesNamespace(): string
    {
        return sprintf('%s.%s.files', $this->databaseName, $this->bucketName);
    }

    private function getRawFileDocumentForStream($stream): object
    {
        if (!is_resource($stream) || get_resource_type($stream) != "stream") {
            throw InvalidArgumentException::invalidType('$stream', $stream, 'resource');
        }
        $metadata = stream_get_meta_data($stream);
        if (!isset($metadata['wrapper_data']) || !$metadata['wrapper_data'] instanceof StreamWrapper) {
            throw InvalidArgumentException::invalidType('$stream wrapper data', $metadata['wrapper_data'] ?? null, StreamWrapper::class);
        }
        return $metadata['wrapper_data']->getFile();
    }

    private function openDownloadStreamByFile(object $file)
    {
        $path = $this->createPathForFile($file);
        $context = stream_context_create([self::$streamWrapperProtocol => ['collectionWrapper' => $this->collectionWrapper, 'file' => $file,],]);
        return fopen($path, 'r', false, $context);
    }

    private function registerStreamWrapper(): void
    {
        if (in_array(self::$streamWrapperProtocol, stream_get_wrappers())) {
            return;
        }
        StreamWrapper::register(self::$streamWrapperProtocol);
    }
}