<?php

namespace Higgs\Test\Mock;

use Higgs\Database\BaseResult;

class MockResult extends BaseResult
{
    public function getFieldCount(): int
    {
        return 0;
    }

    public function getFieldNames(): array
    {
        return [];
    }

    public function getFieldData(): array
    {
        return [];
    }

    public function freeResult()
    {
    }

    public function dataSeek($n = 0)
    {
    }

    public function getNumRows(): int
    {
        return 0;
    }

    protected function fetchAssoc()
    {
    }

    protected function fetchObject($className = 'stdClass')
    {
        return new $className();
    }
}