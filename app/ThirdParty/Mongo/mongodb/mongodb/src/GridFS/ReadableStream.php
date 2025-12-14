<?php

namespace MongoDB\GridFS;

use MongoDB\BSON\Binary;
use MongoDB\Driver\Cursor;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\GridFS\Exception\CorruptFileException;
use function assert;
use function ceil;
use function floor;
use function is_integer;
use function is_object;
use function property_exists;
use function sprintf;
use function strlen;
use function substr;

class ReadableStream
{
    private $buffer;
    private $bufferOffset = 0;
    private $chunkSize;
    private $chunkOffset = 0;
    private $chunksIterator;
    private $collectionWrapper;
    private $expectedLastChunkSize = 0;
    private $file;
    private $length;
    private $numChunks = 0;

    public function __construct(CollectionWrapper $collectionWrapper, object $file)
    {
        if (!isset($file->chunkSize) || !is_integer($file->chunkSize) || $file->chunkSize < 1) {
            throw new CorruptFileException('file.chunkSize is not an integer >= 1');
        }
        if (!isset($file->length) || !is_integer($file->length) || $file->length < 0) {
            throw new CorruptFileException('file.length is not an integer > 0');
        }
        if (!isset($file->_id) && !property_exists($file, '_id')) {
            throw new CorruptFileException('file._id does not exist');
        }
        $this->file = $file;
        $this->chunkSize = $file->chunkSize;
        $this->length = $file->length;
        $this->collectionWrapper = $collectionWrapper;
        if ($this->length > 0) {
            $this->numChunks = (integer)ceil($this->length / $this->chunkSize);
            $this->expectedLastChunkSize = $this->length - (($this->numChunks - 1) * $this->chunkSize);
        }
    }

    public function __debugInfo(): array
    {
        return ['bucketName' => $this->collectionWrapper->getBucketName(), 'databaseName' => $this->collectionWrapper->getDatabaseName(), 'file' => $this->file,];
    }

    public function close(): void
    {
    }

    public function getFile(): object
    {
        return $this->file;
    }

    public function getSize(): int
    {
        return $this->length;
    }

    public function isEOF(): bool
    {
        if ($this->chunkOffset === $this->numChunks - 1) {
            return $this->bufferOffset >= $this->expectedLastChunkSize;
        }
        return $this->chunkOffset >= $this->numChunks;
    }

    public function readBytes(int $length): string
    {
        if ($length < 0) {
            throw new InvalidArgumentException(sprintf('$length must be >= 0; given: %d', $length));
        }
        if ($this->chunksIterator === null) {
            $this->initChunksIterator();
        }
        if ($this->buffer === null && !$this->initBufferFromCurrentChunk()) {
            return '';
        }
        assert($this->buffer !== null);
        $data = '';
        while (strlen($data) < $length) {
            if ($this->bufferOffset >= strlen($this->buffer) && !$this->initBufferFromNextChunk()) {
                break;
            }
            $initialDataLength = strlen($data);
            $data .= substr($this->buffer, $this->bufferOffset, $length - $initialDataLength);
            $this->bufferOffset += strlen($data) - $initialDataLength;
        }
        return $data;
    }

    public function seek(int $offset): void
    {
        if ($offset < 0 || $offset > $this->file->length) {
            throw new InvalidArgumentException(sprintf('$offset must be >= 0 and <= %d; given: %d', $this->file->length, $offset));
        }
        $lastChunkOffset = $this->chunkOffset;
        $this->chunkOffset = (integer)floor($offset / $this->chunkSize);
        $this->bufferOffset = $offset % $this->chunkSize;
        if ($lastChunkOffset === $this->chunkOffset) {
            return;
        }
        if ($this->chunksIterator === null) {
            return;
        }
        $this->buffer = null;
        if ($lastChunkOffset > $this->chunkOffset) {
            $this->chunksIterator = null;
            return;
        }
        $numChunks = $this->chunkOffset - $lastChunkOffset;
        for ($i = 0; $i < $numChunks; $i++) {
            $this->chunksIterator->next();
        }
    }

    public function tell(): int
    {
        return ($this->chunkOffset * $this->chunkSize) + $this->bufferOffset;
    }

    private function initBufferFromCurrentChunk(): bool
    {
        if ($this->chunkOffset === 0 && $this->numChunks === 0) {
            return false;
        }
        if ($this->chunksIterator === null) {
            return false;
        }
        if (!$this->chunksIterator->valid()) {
            throw CorruptFileException::missingChunk($this->chunkOffset);
        }
        $currentChunk = $this->chunksIterator->current();
        assert(is_object($currentChunk));
        if ($currentChunk->n !== $this->chunkOffset) {
            throw CorruptFileException::unexpectedIndex($currentChunk->n, $this->chunkOffset);
        }
        if (!$currentChunk->data instanceof Binary) {
            throw CorruptFileException::invalidChunkData($this->chunkOffset);
        }
        $this->buffer = $currentChunk->data->getData();
        $actualChunkSize = strlen($this->buffer);
        $expectedChunkSize = $this->chunkOffset === $this->numChunks - 1 ? $this->expectedLastChunkSize : $this->chunkSize;
        if ($actualChunkSize !== $expectedChunkSize) {
            throw CorruptFileException::unexpectedSize($actualChunkSize, $expectedChunkSize);
        }
        return true;
    }

    private function initBufferFromNextChunk(): bool
    {
        if ($this->chunkOffset === $this->numChunks - 1) {
            return false;
        }
        if ($this->chunksIterator === null) {
            return false;
        }
        $this->bufferOffset = 0;
        $this->chunkOffset++;
        $this->chunksIterator->next();
        return $this->initBufferFromCurrentChunk();
    }

    private function initChunksIterator(): void
    {
        $this->chunksIterator = $this->collectionWrapper->findChunksByFileId($this->file->_id, $this->chunkOffset);
        $this->chunksIterator->rewind();
    }
}