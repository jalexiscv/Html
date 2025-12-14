<?php

namespace Higgs\Database\MySQLi;

use Higgs\Database\BaseUtils;
use Higgs\Database\Exceptions\DatabaseException;

class Utils extends BaseUtils
{
    protected $listDatabases = 'SHOW DATABASES';
    protected $optimizeTable = 'OPTIMIZE TABLE %s';

    public function _backup(?array $prefs = null)
    {
        throw new DatabaseException('Unsupported feature of the database platform you are using.');
    }
}