<?php

namespace Higgs\Test\Mock;

use Higgs\HTTP\Response;

class MockResponse extends Response
{
    protected $pretend = true;

    public function getPretend()
    {
        return $this->pretend;
    }

    public function misbehave()
    {
        $this->statusCode = 0;
    }
}