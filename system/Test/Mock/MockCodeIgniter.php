<?php

namespace Higgs\Test\Mock;

use Higgs\Higgs;

class MockAnssible extends Higgs
{
    protected ?string $context = 'web';

    protected function callExit($code)
    {
    }
}