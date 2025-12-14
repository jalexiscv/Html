<?php

namespace Higgs\Test\Mock;

use Higgs\Higgs;
use Higgs\Database\BaseConnection;
use Higgs\Database\BaseResult;
use Higgs\Database\Query;

class MockConnection extends BaseConnection
{
    public $database;
    public $lastQuery;
    protected $returnValues = [];
    protected $schema;

    public function shouldReturn(string $method, $return)
    {
        $this->returnValues[$method] = $return;
        return $this;
    }

    public function query(string $sql, $binds = null, bool $setEscapeFlags = true, string $queryClass = '')
    {
        $queryClass = str_replace('Connection', 'Query', static::class);
        $query = new $queryClass($this);
        $query->setQuery($sql, $binds, $setEscapeFlags);
        if (!empty($this->swapPre) && !empty($this->DBPrefix)) {
            $query->swapPrefix($this->DBPrefix, $this->swapPre);
        }
        $startTime = microtime(true);
        $this->lastQuery = $query;
        if (false === ($this->resultID = $this->simpleQuery($query->getQuery()))) {
            $query->setDuration($startTime, $startTime);
            return false;
        }
        $query->setDuration($startTime);
        if ($query->isWriteType()) {
            return true;
        }
        $resultClass = str_replace('Connection', 'Result', static::class);
        return new $resultClass($this->connID, $this->resultID);
    }

    public function connect(bool $persistent = false)
    {
        $return = $this->returnValues['connect'] ?? true;
        if (is_array($return)) {
            $return = array_shift($this->returnValues['connect']);
        }
        return $return;
    }

    public function reconnect(): bool
    {
        return true;
    }

    public function setDatabase(string $databaseName)
    {
        $this->database = $databaseName;
        return $this;
    }

    public function getVersion(): string
    {
        return Higgs::CI_VERSION;
    }

    public function affectedRows(): int
    {
        return 1;
    }

    public function error(): array
    {
        return ['code' => 0, 'message' => '',];
    }

    public function insertID(): int
    {
        return $this->connID->insert_id;
    }

    protected function execute(string $sql)
    {
        return $this->returnValues['execute'];
    }

    protected function _listTables(bool $constrainByPrefix = false, ?string $tableName = null): string
    {
        return '';
    }

    protected function _listColumns(string $table = ''): string
    {
        return '';
    }

    protected function _fieldData(string $table): array
    {
        return [];
    }

    protected function _indexData(string $table): array
    {
        return [];
    }

    protected function _foreignKeyData(string $table): array
    {
        return [];
    }

    protected function _close()
    {
    }

    protected function _transBegin(): bool
    {
        return true;
    }

    protected function _transCommit(): bool
    {
        return true;
    }

    protected function _transRollback(): bool
    {
        return true;
    }
}