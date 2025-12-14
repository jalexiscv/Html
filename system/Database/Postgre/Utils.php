<?php

namespace Higgs\Database\Postgre;

use Higgs\Database\BaseUtils;
use Higgs\Database\Exceptions\DatabaseException;

class Utils extends BaseUtils
{
    protected $listDatabases = 'SELECT datname FROM pg_database';
    protected $optimizeTable = 'REINDEX TABLE %s';

    public function _backup(?array $prefs = null)
    {
        throw new DatabaseException('Unsupported feature of the database platform you are using.');
    }
}