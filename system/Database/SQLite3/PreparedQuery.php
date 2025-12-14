<?php

namespace Higgs\Database\SQLite3;

use BadMethodCallException;
use Higgs\Database\BasePreparedQuery;
use Higgs\Database\Exceptions\DatabaseException;
use SQLite3;
use SQLite3Result;
use SQLite3Stmt;

class PreparedQuery extends BasePreparedQuery
{
    protected $result;

    public function _prepare(string $sql, array $options = []): PreparedQuery
    {
        if (!($this->statement = $this->db->connID->prepare($sql))) {
            $this->errorCode = $this->db->connID->lastErrorCode();
            $this->errorString = $this->db->connID->lastErrorMsg();
            if ($this->db->DBDebug) {
                throw new DatabaseException($this->errorString . ' code: ' . $this->errorCode);
            }
        }
        return $this;
    }

    public function _execute(array $data): bool
    {
        if (!isset($this->statement)) {
            throw new BadMethodCallException('You must call prepare before trying to execute a prepared statement.');
        }
        foreach ($data as $key => $item) {
            if (is_int($item)) {
                $bindType = SQLITE3_INTEGER;
            } elseif (is_float($item)) {
                $bindType = SQLITE3_FLOAT;
            } else {
                $bindType = SQLITE3_TEXT;
            }
            $this->statement->bindValue($key + 1, $item, $bindType);
        }
        $this->result = $this->statement->execute();
        return $this->result !== false;
    }

    public function _getResult()
    {
        return $this->result;
    }

    protected function _close(): bool
    {
        return $this->statement->close();
    }
}