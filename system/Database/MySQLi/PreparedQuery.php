<?php

namespace Higgs\Database\MySQLi;

use BadMethodCallException;
use Higgs\Database\BasePreparedQuery;
use Higgs\Database\Exceptions\DatabaseException;
use mysqli;
use mysqli_result;
use mysqli_sql_exception;
use mysqli_stmt;

class PreparedQuery extends BasePreparedQuery
{
    public function _prepare(string $sql, array $options = []): PreparedQuery
    {
        $sql = rtrim($sql, ';');
        if (!$this->statement = $this->db->mysqli->prepare($sql)) {
            $this->errorCode = $this->db->mysqli->errno;
            $this->errorString = $this->db->mysqli->error;
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
        $bindTypes = '';
        foreach ($data as $item) {
            if (is_int($item)) {
                $bindTypes .= 'i';
            } elseif (is_numeric($item)) {
                $bindTypes .= 'd';
            } else {
                $bindTypes .= 's';
            }
        }
        $this->statement->bind_param($bindTypes, ...$data);
        try {
            return $this->statement->execute();
        } catch (mysqli_sql_exception $e) {
            if ($this->db->DBDebug) {
                throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
            }
            return false;
        }
    }

    public function _getResult()
    {
        return $this->statement->get_result();
    }

    protected function _close(): bool
    {
        return $this->statement->close();
    }
}