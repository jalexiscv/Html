<?php

namespace Higgs\Test\Mock;

use Config\Autoload;

class MockAutoload extends Autoload
{
    public $psr4 = [];
    public $classmap = [];

    public function __construct()
    {
    }
}