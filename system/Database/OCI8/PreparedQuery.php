<?php

namespace Higgs\Database\OCI8;

use BadMethodCallException;
use Higgs\Database\BasePreparedQuery;
use Higgs\Database\Exceptions\DatabaseException;

class PreparedQuery extends BasePreparedQuery
{
    protected $db;
    private ?string $lastInsertTableName = null;

    public function _prepare(string $sql, array $options = []): PreparedQuery
    {
        if (!$this->statement = oci_parse($this->db->connID, $this->parameterize($sql))) {
            $error = oci_error($this->db->connID);
            $this->errorCode = $error['code'] ?? 0;
            $this->errorString = $error['message'] ?? '';
            if ($this->db->DBDebug) {
                throw new DatabaseException($this->errorString . ' code: ' . $this->errorCode);
            }
        }
        $this->lastInsertTableName = $this->db->parseInsertTableName($sql);
        return $this;
    }

    public function parameterize(string $sql): string
    {
        $count = 0;
        return preg_replace_callback('/\?/', static function ($matches) use (&$count) {
            return ':' . ($count++);
        }, $sql);
    }

    public function _execute(array $data): bool
    {
        if (!isset($this->statement)) {
            throw new BadMethodCallException('You must call prepare before trying to execute a prepared statement.');
        }
        foreach (array_keys($data) as $key) {
            oci_bind_by_name($this->statement, ':' . $key, $data[$key]);
        }
        $result = oci_execute($this->statement, $this->db->commitMode);
        if ($result && $this->lastInsertTableName !== '') {
            $this->db->lastInsertedTableName = $this->lastInsertTableName;
        }
        return $result;
    }

    public function _getResult()
    {
        return $this->statement;
    }

    protected function _close(): bool
    {
        return oci_free_statement($this->statement);
    }
}