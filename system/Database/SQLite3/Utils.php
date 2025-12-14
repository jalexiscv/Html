<?php

namespace Higgs\Database\SQLite3;

use Higgs\Database\BaseUtils;
use Higgs\Database\Exceptions\DatabaseException;

class Utils extends BaseUtils
{
    protected $optimizeTable = 'REINDEX %s';

    public function _backup(?array $prefs = null)
    {
        throw new DatabaseException('Unsupported feature of the database platform you are using.');
    }
}