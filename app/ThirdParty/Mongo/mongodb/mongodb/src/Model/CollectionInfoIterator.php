<?php

namespace MongoDB\Model;

use Iterator;
use ReturnTypeWillChange;

interface CollectionInfoIterator extends Iterator
{
    #[ReturnTypeWillChange] public function current();
}