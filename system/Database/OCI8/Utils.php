<?php

namespace Higgs\Database\OCI8;

use Higgs\Database\BaseUtils;
use Higgs\Database\Exceptions\DatabaseException;

class Utils extends BaseUtils
{
    protected $listDatabases = 'SELECT TABLESPACE_NAME FROM USER_TABLESPACES';

    public function _backup(?array $prefs = null)
    {
        throw new DatabaseException('Unsupported feature of the database platform you are using.');
    }
}