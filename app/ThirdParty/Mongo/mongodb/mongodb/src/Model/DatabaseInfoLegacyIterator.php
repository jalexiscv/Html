<?php

namespace MongoDB\Model;

use function current;
use function key;
use function next;
use function reset;

class DatabaseInfoLegacyIterator implements DatabaseInfoIterator
{
    private $databases;

    public function __construct(array $databases)
    {
        $this->databases = $databases;
    }

    public function current(): DatabaseInfo
    {
        return new DatabaseInfo(current($this->databases));
    }

    public function key(): int
    {
        return key($this->databases);
    }

    public function next(): void
    {
        next($this->databases);
    }

    public function rewind(): void
    {
        reset($this->databases);
    }

    public function valid(): bool
    {
        return key($this->databases) !== null;
    }
}