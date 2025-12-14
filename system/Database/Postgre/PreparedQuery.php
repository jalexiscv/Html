<?php

namespace Higgs\Database\Postgre;

use BadMethodCallException;
use Higgs\Database\BasePreparedQuery;
use Higgs\Database\Exceptions\DatabaseException;
use Exception;
use PgSql\Connection as PgSqlConnection;
use PgSql\Result as PgSqlResult;

class PreparedQuery extends BasePreparedQuery
{
    protected $name;
    protected $result;

    public function _prepare(string $sql, array $options = []): PreparedQuery
    {
        $this->name = (string)random_int(1, 10_000_000_000_000_000);
        $sql = $this->parameterize($sql);
        $this->query->setQuery($sql);
        if (!$this->statement = pg_prepare($this->db->connID, $this->name, $sql)) {
            $this->errorCode = 0;
            $this->errorString = pg_last_error($this->db->connID);
            if ($this->db->DBDebug) {
                throw new DatabaseException($this->errorString . ' code: ' . $this->errorCode);
            }
        }
        return $this;
    }

    public function parameterize(string $sql): string
    {
        $count = 0;
        return preg_replace_callback('/\?/', static function () use (&$count) {
            $count++;
            return "\${$count}";
        }, $sql);
    }

    public function _execute(array $data): bool
    {
        if (!isset($this->statement)) {
            throw new BadMethodCallException('You must call prepare before trying to execute a prepared statement.');
        }
        $this->result = pg_execute($this->db->connID, $this->name, $data);
        return (bool)$this->result;
    }

    public function _getResult()
    {
        return $this->result;
    }

    protected function _close(): bool
    {
        return pg_query($this->db->connID, 'DEALLOCATE "' . $this->db->escapeIdentifiers($this->name) . '"') !== false;
    }
}