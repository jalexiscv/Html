<?php

namespace MongoDB\GridFS;

use HashContext;
use MongoDB\BSON\Binary;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Exception\InvalidArgumentException;
use function array_intersect_key;
use function hash_final;
use function hash_init;
use function hash_update;
use function is_array;
use function is_bool;
use function is_integer;
use function is_object;
use function is_string;
use function MongoDB\is_string_array;
use function sprintf;
use function strlen;
use function substr;

class WritableStream
{
    private static $defaultChunkSizeBytes = 261120;
    private $buffer = '';
    private $chunkOffset = 0;
    private $chunkSize;
    private $disableMD5;
    private $collectionWrapper;
    private $file;
    private $hashCtx;
    private $isClosed = false;
    private $length = 0;

    public function __construct(CollectionWrapper $collectionWrapper, string $filename, array $options = [])
    {
        $options += ['_id' => new ObjectId(), 'chunkSizeBytes' => self::$defaultChunkSizeBytes, 'disableMD5' => false,];
        if (isset($options['aliases']) && !is_string_array($options['aliases'])) {
            throw InvalidArgumentException::invalidType('"aliases" option', $options['aliases'], 'array of strings');
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
        if (isset($options['contentType']) && !is_string($options['contentType'])) {
            throw InvalidArgumentException::invalidType('"contentType" option', $options['contentType'], 'string');
        }
        if (isset($options['metadata']) && !is_array($options['metadata']) && !is_object($options['metadata'])) {
            throw InvalidArgumentException::invalidType('"metadata" option', $options['metadata'], 'array or object');
        }
        $this->chunkSize = $options['chunkSizeBytes'];
        $this->collectionWrapper = $collectionWrapper;
        $this->disableMD5 = $options['disableMD5'];
        if (!$this->disableMD5) {
            $this->hashCtx = hash_init('md5');
        }
        $this->file = ['_id' => $options['_id'], 'chunkSize' => $this->chunkSize, 'filename' => $filename,] + array_intersect_key($options, ['aliases' => 1, 'contentType' => 1, 'metadata' => 1]);
    }

    public function __debugInfo(): array
    {
        return ['bucketName' => $this->collectionWrapper->getBucketName(), 'databaseName' => $this->collectionWrapper->getDatabaseName(), 'file' => $this->file,];
    }

    public function close(): void
    {
        if ($this->isClosed) {
            return;
        }
        if (strlen($this->buffer) > 0) {
            $this->insertChunkFromBuffer();
        }
        $this->fileCollectionInsert();
        $this->isClosed = true;
    }

    public function getFile(): object
    {
        return (object)$this->file;
    }

    public function getSize(): int
    {
        return $this->length + strlen($this->buffer);
    }

    public function tell(): int
    {
        return $this->getSize();
    }

    public function writeBytes(string $data): int
    {
        if ($this->isClosed) {
            return 0;
        }
        $bytesRead = 0;
        while ($bytesRead != strlen($data)) {
            $initialBufferLength = strlen($this->buffer);
            $this->buffer .= substr($data, $bytesRead, $this->chunkSize - $initialBufferLength);
            $bytesRead += strlen($this->buffer) - $initialBufferLength;
            if (strlen($this->buffer) == $this->chunkSize) {
                $this->insertChunkFromBuffer();
            }
        }
        return $bytesRead;
    }

    private function abort(): void
    {
        try {
            $this->collectionWrapper->deleteChunksByFilesId($this->file['_id']);
        } catch (DriverRuntimeException $e) {
        }
        $this->isClosed = true;
    }

    private function fileCollectionInsert()
    {
        $this->file['length'] = $this->length;
        $this->file['uploadDate'] = new UTCDateTime();
        if (!$this->disableMD5 && $this->hashCtx) {
            $this->file['md5'] = hash_final($this->hashCtx);
        }
        try {
            $this->collectionWrapper->insertFile($this->file);
        } catch (DriverRuntimeException $e) {
            $this->abort();
            throw $e;
        }
        return $this->file['_id'];
    }

    private function insertChunkFromBuffer(): void
    {
        if (strlen($this->buffer) == 0) {
            return;
        }
        $data = $this->buffer;
        $this->buffer = '';
        $chunk = ['files_id' => $this->file['_id'], 'n' => $this->chunkOffset, 'data' => new Binary($data, Binary::TYPE_GENERIC),];
        if (!$this->disableMD5 && $this->hashCtx) {
            hash_update($this->hashCtx, $data);
        }
        try {
            $this->collectionWrapper->insertChunk($chunk);
        } catch (DriverRuntimeException $e) {
            $this->abort();
            throw $e;
        }
        $this->length += strlen($data);
        $this->chunkOffset++;
    }
}