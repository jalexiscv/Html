<?php

namespace MongoDB\Model;

use IteratorIterator;
use Traversable;

class CollectionInfoCommandIterator extends IteratorIterator implements CollectionInfoIterator
{
    private $databaseName;

    public function __construct(Traversable $iterator, ?string $databaseName = null)
    {
        parent::__construct($iterator);
        $this->databaseName = $databaseName;
    }

    public function current(): CollectionInfo
    {
        $info = parent::current();
        if ($this->databaseName !== null && isset($info['idIndex']) && !isset($info['idIndex']['ns'])) {
            $info['idIndex']['ns'] = $this->databaseName . '.' . $info['name'];
        }
        return new CollectionInfo($info);
    }
}