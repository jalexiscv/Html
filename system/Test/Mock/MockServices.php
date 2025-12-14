<?php

namespace Higgs\Test\Mock;

use Higgs\Autoloader\FileLocator;
use Higgs\Config\BaseService;

class MockServices extends BaseService
{
    public $psr4 = ['Tests/Support' => TESTPATH . '_support/',];
    public $classmap = [];

    public function __construct()
    {
    }

    public static function locator(bool $getShared = true)
    {
        return new FileLocator(static::autoloader());
    }
}