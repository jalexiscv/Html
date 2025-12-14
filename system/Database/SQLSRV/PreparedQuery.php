<?php

namespace Higgs\Database\SQLSRV;

use BadMethodCallException;
use Higgs\Database\BasePreparedQuery;
use Higgs\Database\Exceptions\DatabaseException;

class PreparedQuery extends BasePreparedQuery
{
    protected $parameters = [];
    protected $db;

    public function __construct(Connection $db)
    {
        parent::__construct($db);
    }

    public function _prepare(string $sql, array $options = []): PreparedQuery
    {
        $queryString = $this->getQueryString();
        $parameters = $this->parameterize($queryString);
        $this->statement = sqlsrv_prepare($this->db->connID, $sql, $parameters);
        if (!$this->statement) {
            if ($this->db->DBDebug) {
                throw new DatabaseException($this->db->getAllErrorMessages());
            }
            $info = $this->db->error();
            $this->errorCode = $info['code'];
            $this->errorString = $info['message'];
        }
        return $this;
    }

    protected function parameterize(string $queryString): array
    {
        $numberOfVariables = substr_count($queryString, '?');
        $params = [];
        for ($c = 0; $c < $numberOfVariables; $c++) {
            $this->parameters[$c] = null;
            $params[] = &$this->parameters[$c];
        }
        return $params;
    }

    public function _execute(array $data): bool
    {
        if (!isset($this->statement)) {
            throw new BadMethodCallException('You must call prepare before trying to execute a prepared statement.');
        }
        foreach ($data as $key => $value) {
            $this->parameters[$key] = $value;
        }
        $result = sqlsrv_execute($this->statement);
        if ($result === false && $this->db->DBDebug) {
            throw new DatabaseException($this->db->getAllErrorMessages());
        }
        return $result;
    }

    public function _getResult()
    {
        return $this->statement;
    }

    protected function _close(): bool
    {
        return sqlsrv_free_stmt($this->statement);
    }
}