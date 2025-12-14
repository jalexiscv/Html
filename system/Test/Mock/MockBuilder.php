<?php

namespace Higgs\Test\Mock;

use Higgs\Database\BaseBuilder;

class MockBuilder extends BaseBuilder
{
    protected $supportedIgnoreStatements = ['update' => 'IGNORE', 'insert' => 'IGNORE', 'delete' => 'IGNORE',];
}