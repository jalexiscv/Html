<?php

namespace MongoDB\Model;

use Iterator;
use ReturnTypeWillChange;

interface DatabaseInfoIterator extends Iterator
{
    #[ReturnTypeWillChange] public function current();
}