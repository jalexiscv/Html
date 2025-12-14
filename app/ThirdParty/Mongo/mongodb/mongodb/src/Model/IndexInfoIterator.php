<?php

namespace MongoDB\Model;

use Iterator;
use ReturnTypeWillChange;

interface IndexInfoIterator extends Iterator
{
    #[ReturnTypeWillChange] public function current();
}