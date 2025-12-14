<?php

namespace MongoDB\GridFS;

use MongoDB\BSON\UTCDateTime;
use function assert;
use function explode;
use function in_array;
use function is_integer;
use function is_resource;
use function stream_context_get_options;
use function stream_get_wrappers;
use function stream_wrapper_register;
use function stream_wrapper_unregister;
use const SEEK_CUR;
use const SEEK_END;
use const SEEK_SET;
use const STREAM_IS_URL;

class StreamWrapper
{
    public $context;
    private $mode;
    private $protocol;
    private $stream;

    public function __destruct()
    {
        $this->stream = null;
    }

    public function getFile(): object
    {
        assert($this->stream !== null);
        return $this->stream->getFile();
    }

    public static function register(string $protocol = 'gridfs'): void
    {
        if (in_array($protocol, stream_get_wrappers())) {
            stream_wrapper_unregister($protocol);
        }
        stream_wrapper_register($protocol, static::class, STREAM_IS_URL);
    }

    public function stream_close(): void
    {
        if (!$this->stream) {
            return;
        }
        $this->stream->close();
    }

    public function stream_eof(): bool
    {
        if (!$this->stream instanceof ReadableStream) {
            return false;
        }
        return $this->stream->isEOF();
    }

    public function stream_open(string $path, string $mode, int $options, ?string &$openedPath): bool
    {
        $this->initProtocol($path);
        $this->mode = $mode;
        if ($mode === 'r') {
            return $this->initReadableStream();
        }
        if ($mode === 'w') {
            return $this->initWritableStream();
        }
        return false;
    }

    public function stream_read(int $length): string
    {
        if (!$this->stream instanceof ReadableStream) {
            return '';
        }
        return $this->stream->readBytes($length);
    }

    public function stream_seek(int $offset, int $whence = SEEK_SET): bool
    {
        assert($this->stream !== null);
        $size = $this->stream->getSize();
        if ($whence === SEEK_CUR) {
            $offset += $this->stream->tell();
        }
        if ($whence === SEEK_END) {
            $offset += $size;
        }
        if ($this->stream instanceof WritableStream) {
            return $offset === $size;
        }
        if ($offset < 0 || $offset > $size) {
            return false;
        }
        $this->stream->seek($offset);
        return true;
    }

    public function stream_stat(): array
    {
        assert($this->stream !== null);
        $stat = $this->getStatTemplate();
        $stat[2] = $stat['mode'] = $this->stream instanceof ReadableStream ? 0100444 : 0100222;
        $stat[7] = $stat['size'] = $this->stream->getSize();
        $file = $this->stream->getFile();
        if (isset($file->uploadDate) && $file->uploadDate instanceof UTCDateTime) {
            $timestamp = $file->uploadDate->toDateTime()->getTimestamp();
            $stat[9] = $stat['mtime'] = $timestamp;
            $stat[10] = $stat['ctime'] = $timestamp;
        }
        if (isset($file->chunkSize) && is_integer($file->chunkSize)) {
            $stat[11] = $stat['blksize'] = $file->chunkSize;
        }
        return $stat;
    }

    public function stream_tell(): int
    {
        assert($this->stream !== null);
        return $this->stream->tell();
    }

    public function stream_write(string $data): int
    {
        if (!$this->stream instanceof WritableStream) {
            return 0;
        }
        return $this->stream->writeBytes($data);
    }

    private function getStatTemplate(): array
    {
        return [0 => 0, 'dev' => 0, 1 => 0, 'ino' => 0, 2 => 0, 'mode' => 0, 3 => 0, 'nlink' => 0, 4 => 0, 'uid' => 0, 5 => 0, 'gid' => 0, 6 => -1, 'rdev' => -1, 7 => 0, 'size' => 0, 8 => 0, 'atime' => 0, 9 => 0, 'mtime' => 0, 10 => 0, 'ctime' => 0, 11 => -1, 'blksize' => -1, 12 => -1, 'blocks' => -1,];
    }

    private function initProtocol(string $path): void
    {
        $parts = explode('://', $path, 2);
        $this->protocol = $parts[0] ?: 'gridfs';
    }

    private function initReadableStream(): bool
    {
        assert(is_resource($this->context));
        $context = stream_context_get_options($this->context);
        assert($this->protocol !== null);
        $this->stream = new ReadableStream($context[$this->protocol]['collectionWrapper'], $context[$this->protocol]['file']);
        return true;
    }

    private function initWritableStream(): bool
    {
        assert(is_resource($this->context));
        $context = stream_context_get_options($this->context);
        assert($this->protocol !== null);
        $this->stream = new WritableStream($context[$this->protocol]['collectionWrapper'], $context[$this->protocol]['filename'], $context[$this->protocol]['options']);
        return true;
    }
}