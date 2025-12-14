<?php

namespace Higgs\Test\Interfaces;

use Faker\Generator;
use ReflectionException;

interface FabricatorModel
{
    public function find($id = null);

    public function insert($data = null, bool $returnID = true);
}