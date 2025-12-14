<?php

namespace MongoDB\GridFS\Exception;

use MongoDB\Exception\RuntimeException;
use function sprintf;

class CorruptFileException extends RuntimeException
{
    public static function invalidChunkData(int $chunkIndex): self
    {
        return new static(sprintf('Invalid data found for index "%d"', $chunkIndex));
    }

    public static function missingChunk(int $expectedIndex)
    {
        return new static(sprintf('Chunk not found for index "%d"', $expectedIndex));
    }

    public static function unexpectedIndex(int $index, int $expectedIndex)
    {
        return new static(sprintf('Expected chunk to have index "%d" but found "%d"', $expectedIndex, $index));
    }

    public static function unexpectedSize(int $size, int $expectedSize)
    {
        return new static(sprintf('Expected chunk to have size "%d" but found "%d"', $expectedSize, $size));
    }
}