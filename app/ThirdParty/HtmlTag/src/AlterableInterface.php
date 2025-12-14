<?php

namespace drupol\htmltag;
interface AlterableInterface
{
    public function alter(callable ...$closures);
}