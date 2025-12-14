<?php

namespace MongoDB\Model;

use IteratorIterator;
use Traversable;
use function array_key_exists;

class IndexInfoIteratorIterator extends IteratorIterator implements IndexInfoIterator
{
    private $ns;

    public function __construct(Traversable $iterator, ?string $ns = null)
    {
        parent::__construct($iterator);
        $this->ns = $ns;
    }

    public function current(): IndexInfo
    {
        $info = parent::current();
        if (!array_key_exists('ns', $info) && $this->ns !== null) {
            $info['ns'] = $this->ns;
        }
        return new IndexInfo($info);
    }
}