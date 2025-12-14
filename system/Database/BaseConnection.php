<?php

namespace Higgs\Database;

use Closure;
use Higgs\Database\Exceptions\DatabaseException;
use Higgs\Events\Events;
use stdClass;
use Throwable;

abstract class BaseConnection implements ConnectionInterface
{
    public $connID = false;
    public $resultID = false;
    public $protectIdentifiers = true;
    public $escapeChar = '"';
    public $likeEscapeStr = " ESCAPE '%s' ";
    public $likeEscapeChar = '!';
    public $dataCache = [];
    public $transEnabled = true;
    public $transStrict = true;
    protected $DSN;
    protected $port = '';
    protected $hostname;
    protected $username;
    protected $password;
    protected $database;
    protected $DBDriver = 'MySQLi';
    protected $subdriver;
    protected $DBPrefix = '';
    protected $pConnect = false;
    protected $DBDebug = true;
    protected $charset = 'utf8';
    protected $DBCollat = 'utf8_general_ci';
    protected $swapPre = '';
    protected $encrypt = false;
    protected $compress = false;
    protected $strictOn;
    protected $failover = [];
    protected $lastQuery;
    protected $reservedIdentifiers = ['*'];
    protected $pregEscapeChar = [];
    protected $connectTime = 0.0;
    protected $connectDuration = 0.0;
    protected $pretend = false;
    protected $transDepth = 0;
    protected $transStatus = true;
    protected $transFailure = false;
    protected bool $transException = false;
    protected $aliasedTables = [];
    protected $queryClass = Query::class;

    public function __construct(array $params)
    {
        foreach ($params as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
        $queryClass = str_replace('Connection', 'Query', static::class);
        if (class_exists($queryClass)) {
            $this->queryClass = $queryClass;
        }
        if ($this->failover !== []) {
            $this->initialize();
        }
    }

    public function initialize()
    {
        if ($this->connID) {
            return;
        }
        $this->connectTime = microtime(true);
        $connectionErrors = [];
        try {
            $this->connID = $this->connect($this->pConnect);
        } catch (Throwable $e) {
            $connectionErrors[] = sprintf('Main connection [%s]: %s', $this->DBDriver, $e->getMessage());
            log_message('error', 'Error connecting to the database: ' . $e);
        }
        if (!$this->connID) {
            if (!empty($this->failover) && is_array($this->failover)) {
                foreach ($this->failover as $index => $failover) {
                    foreach ($failover as $key => $val) {
                        if (property_exists($this, $key)) {
                            $this->{$key} = $val;
                        }
                    }
                    try {
                        $this->connID = $this->connect($this->pConnect);
                    } catch (Throwable $e) {
                        $connectionErrors[] = sprintf('Failover #%d [%s]: %s', ++$index, $this->DBDriver, $e->getMessage());
                        log_message('error', 'Error connecting to the database: ' . $e);
                    }
                    if ($this->connID) {
                        break;
                    }
                }
            }
            if (!$this->connID) {
                throw new DatabaseException(sprintf('Unable to connect to the database.%s%s', PHP_EOL, implode(PHP_EOL, $connectionErrors)));
            }
        }
        $this->connectDuration = microtime(true) - $this->connectTime;
    }

    public function close()
    {
        if ($this->connID) {
            $this->_close();
            $this->connID = false;
        }
    }

    abstract protected function _close();

    public function persistentConnect()
    {
        return $this->connect(true);
    }

    public function getConnection(?string $alias = null)
    {
        return $this->connID;
    }

    public function getDatabase(): string
    {
        return empty($this->database) ? '' : $this->database;
    }

    public function setPrefix(string $prefix = ''): string
    {
        return $this->DBPrefix = $prefix;
    }

    public function getPrefix(): string
    {
        return $this->DBPrefix;
    }

    public function getPlatform(): string
    {
        return $this->DBDriver;
    }

    public function setAliasedTables(array $aliases)
    {
        $this->aliasedTables = $aliases;
        return $this;
    }

    public function addTableAlias(string $table)
    {
        if (!in_array($table, $this->aliasedTables, true)) {
            $this->aliasedTables[] = $table;
        }
        return $this;
    }

    public function transOff()
    {
        $this->transEnabled = false;
    }

    public function transStrict(bool $mode = true)
    {
        $this->transStrict = $mode;
        return $this;
    }

    public function transStart(bool $testMode = false): bool
    {
        if (!$this->transEnabled) {
            return false;
        }
        return $this->transBegin($testMode);
    }

    public function transBegin(bool $testMode = false): bool
    {
        if (!$this->transEnabled) {
            return false;
        }
        if ($this->transDepth > 0) {
            $this->transDepth++;
            return true;
        }
        if (empty($this->connID)) {
            $this->initialize();
        }
        $this->transFailure = ($testMode === true);
        if ($this->_transBegin()) {
            $this->transDepth++;
            return true;
        }
        return false;
    }

    abstract protected function _transBegin(): bool;

    public function transException(bool $transExcetion)
    {
        $this->transException = $transExcetion;
        return $this;
    }

    public function transStatus(): bool
    {
        return $this->transStatus;
    }

    public function newQuery(): BaseBuilder
    {
        $tempAliases = $this->aliasedTables;
        $builder = $this->table(',')->from([], true);
        $this->aliasedTables = $tempAliases;
        return $builder;
    }

    public function table($tableName)
    {
        if (empty($tableName)) {
            throw new DatabaseException('You must set the database table to be used with your query.');
        }
        $className = str_replace('Connection', 'Builder', static::class);
        return new $className($tableName, $this);
    }

    public function prepare(Closure $func, array $options = [])
    {
        if (empty($this->connID)) {
            $this->initialize();
        }
        $this->pretend();
        $sql = $func($this);
        $this->pretend(false);
        if ($sql instanceof QueryInterface) {
            $sql = $sql->getOriginalQuery();
        }
        $class = str_ireplace('Connection', 'PreparedQuery', static::class);
        $class = new $class($this);
        return $class->prepare($sql, $options);
    }

    public function pretend(bool $pretend = true)
    {
        $this->pretend = $pretend;
        return $this;
    }

    public function getLastQuery()
    {
        return $this->lastQuery;
    }

    public function showLastQuery(): string
    {
        return (string)$this->lastQuery;
    }

    public function getConnectStart(): ?float
    {
        return $this->connectTime;
    }

    public function getConnectDuration(int $decimals = 6): string
    {
        return number_format($this->connectDuration, $decimals);
    }

    public function prefixTable(string $table = ''): string
    {
        if ($table === '') {
            throw new DatabaseException('A table name is required for that operation.');
        }
        return $this->DBPrefix . $table;
    }

    abstract public function affectedRows(): int;

    public function escape($str)
    {
        if (is_array($str)) {
            return array_map([&$this, 'escape'], $str);
        }
        if (is_string($str) || (is_object($str) && method_exists($str, '__toString'))) {
            if ($str instanceof RawSql) {
                return $str->__toString();
            }
            return "'" . $this->escapeString($str) . "'";
        }
        if (is_bool($str)) {
            return ($str === false) ? 0 : 1;
        }
        return $str ?? 'NULL';
    }

    public function escapeString($str, bool $like = false)
    {
        if (is_array($str)) {
            foreach ($str as $key => $val) {
                $str[$key] = $this->escapeString($val, $like);
            }
            return $str;
        }
        $str = $this->_escapeString($str);
        if ($like === true) {
            return str_replace([$this->likeEscapeChar, '%', '_',], [$this->likeEscapeChar . $this->likeEscapeChar, $this->likeEscapeChar . '%', $this->likeEscapeChar . '_',], $str);
        }
        return $str;
    }

    protected function _escapeString(string $str): string
    {
        return str_replace("'", "''", remove_invisible_characters($str, false));
    }

    public function escapeLikeString($str)
    {
        return $this->escapeString($str, true);
    }

    public function callFunction(string $functionName, ...$params): bool
    {
        $driver = $this->getDriverFunctionPrefix();
        if (strpos($driver, $functionName) === false) {
            $functionName = $driver . $functionName;
        }
        if (!function_exists($functionName)) {
            if ($this->DBDebug) {
                throw new DatabaseException('This feature is not available for the database you are using.');
            }
            return false;
        }
        return $functionName(...$params);
    }

    protected function getDriverFunctionPrefix(): string
    {
        return strtolower($this->DBDriver) . '_';
    }

    public function tableExists(string $tableName, bool $cached = true): bool
    {
        if ($cached === true) {
            return in_array($this->protectIdentifiers($tableName, true, false, false), $this->listTables(), true);
        }
        if (false === ($sql = $this->_listTables(false, $tableName))) {
            if ($this->DBDebug) {
                throw new DatabaseException('This feature is not available for the database you are using.');
            }
            return false;
        }
        $tableExists = $this->query($sql)->getResultArray() !== [];
        if (!empty($this->dataCache['table_names'])) {
            $key = array_search(strtolower($tableName), array_map('strtolower', $this->dataCache['table_names']), true);
            if (($key !== false && !$tableExists) || ($key === false && $tableExists)) {
                $this->resetDataCache();
            }
        }
        return $tableExists;
    }

    public function protectIdentifiers($item, bool $prefixSingle = false, ?bool $protectIdentifiers = null, bool $fieldExists = true)
    {
        if (!is_bool($protectIdentifiers)) {
            $protectIdentifiers = $this->protectIdentifiers;
        }
        if (is_array($item)) {
            $escapedArray = [];
            foreach ($item as $k => $v) {
                $escapedArray[$this->protectIdentifiers($k)] = $this->protectIdentifiers($v, $prefixSingle, $protectIdentifiers, $fieldExists);
            }
            return $escapedArray;
        }
        if (strcspn($item, "()'") !== strlen($item)) {
            return $item;
        }
        if ($protectIdentifiers === false && $prefixSingle === false && $this->swapPre === '') {
            return $item;
        }
        $item = preg_replace('/\s+/', ' ', trim($item));
        if ($offset = strripos($item, ' AS ')) {
            $alias = ($protectIdentifiers) ? substr($item, $offset, 4) . $this->escapeIdentifiers(substr($item, $offset + 4)) : substr($item, $offset);
            $item = substr($item, 0, $offset);
        } elseif ($offset = strrpos($item, ' ')) {
            $alias = ($protectIdentifiers) ? ' ' . $this->escapeIdentifiers(substr($item, $offset + 1)) : substr($item, $offset);
            $item = substr($item, 0, $offset);
        } else {
            $alias = '';
        }
        if (strpos($item, '.') !== false) {
            return $this->protectDotItem($item, $alias, $protectIdentifiers, $fieldExists);
        }
        $item = trim($item, $this->escapeChar);
        if ($this->DBPrefix !== '') {
            if ($this->swapPre !== '' && strpos($item, $this->swapPre) === 0) {
                $item = preg_replace('/^' . $this->swapPre . '(\S+?)/', $this->DBPrefix . '\\1', $item);
            } elseif ($prefixSingle === true && strpos($item, $this->DBPrefix) !== 0) {
                $item = $this->DBPrefix . $item;
            }
        }
        if ($protectIdentifiers === true && !in_array($item, $this->reservedIdentifiers, true)) {
            $item = $this->escapeIdentifiers($item);
        }
        return $item . $alias;
    }

    public function escapeIdentifiers($item)
    {
        if ($this->escapeChar === '' || empty($item) || in_array($item, $this->reservedIdentifiers, true)) {
            return $item;
        }
        if (is_array($item)) {
            foreach ($item as $key => $value) {
                $item[$key] = $this->escapeIdentifiers($value);
            }
            return $item;
        }
        if (ctype_digit($item) || $item[0] === "'" || ($this->escapeChar !== '"' && $item[0] === '"') || strpos($item, '(') !== false) {
            return $item;
        }
        if ($this->pregEscapeChar === []) {
            if (is_array($this->escapeChar)) {
                $this->pregEscapeChar = [preg_quote($this->escapeChar[0], '/'), preg_quote($this->escapeChar[1], '/'), $this->escapeChar[0], $this->escapeChar[1],];
            } else {
                $this->pregEscapeChar[0] = $this->pregEscapeChar[1] = preg_quote($this->escapeChar, '/');
                $this->pregEscapeChar[2] = $this->pregEscapeChar[3] = $this->escapeChar;
            }
        }
        foreach ($this->reservedIdentifiers as $id) {
            if (strpos($item, '.' . $id) !== false) {
                return preg_replace('/' . $this->pregEscapeChar[0] . '?([^' . $this->pregEscapeChar[1] . '\.]+)' . $this->pregEscapeChar[1] . '?\./i', $this->pregEscapeChar[2] . '$1' . $this->pregEscapeChar[3] . '.', $item);
            }
        }
        return preg_replace('/' . $this->pregEscapeChar[0] . '?([^' . $this->pregEscapeChar[1] . '\.]+)' . $this->pregEscapeChar[1] . '?(\.)?/i', $this->pregEscapeChar[2] . '$1' . $this->pregEscapeChar[3] . '$2', $item);
    }

    private function protectDotItem(string $item, string $alias, bool $protectIdentifiers, bool $fieldExists): string
    {
        $parts = explode('.', $item);
        if (!empty($this->aliasedTables) && in_array($parts[0], $this->aliasedTables, true)) {
            if ($protectIdentifiers === true) {
                foreach ($parts as $key => $val) {
                    if (!in_array($val, $this->reservedIdentifiers, true)) {
                        $parts[$key] = $this->escapeIdentifiers($val);
                    }
                }
                $item = implode('.', $parts);
            }
            return $item . $alias;
        }
        if ($this->DBPrefix !== '') {
            if (isset($parts[3])) {
                $i = 2;
            } elseif (isset($parts[2])) {
                $i = 1;
            } else {
                $i = 0;
            }
            if ($fieldExists === false) {
                $i++;
            }
            if ($this->swapPre !== '' && strpos($parts[$i], $this->swapPre) === 0) {
                $parts[$i] = preg_replace('/^' . $this->swapPre . '(\S+?)/', $this->DBPrefix . '\\1', $parts[$i]);
            } elseif (strpos($parts[$i], $this->DBPrefix) !== 0) {
                $parts[$i] = $this->DBPrefix . $parts[$i];
            }
            $item = implode('.', $parts);
        }
        if ($protectIdentifiers === true) {
            $item = $this->escapeIdentifiers($item);
        }
        return $item . $alias;
    }

    public function listTables(bool $constrainByPrefix = false)
    {
        if (isset($this->dataCache['table_names']) && $this->dataCache['table_names']) {
            return $constrainByPrefix ? preg_grep("/^{$this->DBPrefix}/", $this->dataCache['table_names']) : $this->dataCache['table_names'];
        }
        $sql = $this->_listTables($constrainByPrefix);
        if ($sql === false) {
            if ($this->DBDebug) {
                throw new DatabaseException('This feature is not available for the database you are using.');
            }
            return false;
        }
        $this->dataCache['table_names'] = [];
        $query = $this->query($sql);
        foreach ($query->getResultArray() as $row) {
            $table = $row['table_name'] ?? $row['TABLE_NAME'] ?? $row[array_key_first($row)];
            $this->dataCache['table_names'][] = $table;
        }
        return $this->dataCache['table_names'];
    }

    abstract protected function _listTables(bool $constrainByPrefix = false, ?string $tableName = null);

    public function query(string $sql, $binds = null, bool $setEscapeFlags = true, string $queryClass = '')
    {
        $queryClass = $queryClass ?: $this->queryClass;
        if (empty($this->connID)) {
            $this->initialize();
        }
        $query = new $queryClass($this);
        $query->setQuery($sql, $binds, $setEscapeFlags);
        if (!empty($this->swapPre) && !empty($this->DBPrefix)) {
            $query->swapPrefix($this->DBPrefix, $this->swapPre);
        }
        $startTime = microtime(true);
        $this->lastQuery = $query;
        if ($this->pretend) {
            $query->setDuration($startTime);
            return $query;
        }
        try {
            $exception = null;
            $this->resultID = $this->simpleQuery($query->getQuery());
        } catch (DatabaseException $exception) {
            $this->resultID = false;
        }
        if ($this->resultID === false) {
            $query->setDuration($startTime, $startTime);
            if ($this->transDepth !== 0) {
                $this->transStatus = false;
            }
            if ($this->DBDebug && ($this->transDepth === 0 || $this->transException)) {
                while ($this->transDepth !== 0) {
                    $transDepth = $this->transDepth;
                    $this->transComplete();
                    if ($transDepth === $this->transDepth) {
                        log_message('error', 'Database: Failure during an automated transaction commit/rollback!');
                        break;
                    }
                }
                Events::trigger('DBQuery', $query);
                if ($exception !== null) {
                    throw new DatabaseException($exception->getMessage(), $exception->getCode(), $exception);
                }
                return false;
            }
            Events::trigger('DBQuery', $query);
            return false;
        }
        $query->setDuration($startTime);
        Events::trigger('DBQuery', $query);
        if ($this->isWriteType($sql)) {
            return true;
        }
        $resultClass = str_replace('Connection', 'Result', static::class);
        return new $resultClass($this->connID, $this->resultID);
    }

    public function simpleQuery(string $sql)
    {
        if (empty($this->connID)) {
            $this->initialize();
        }
        return $this->execute($sql);
    }

    abstract protected function execute(string $sql);

    public function transComplete(): bool
    {
        if (!$this->transEnabled) {
            return false;
        }
        if ($this->transStatus === false || $this->transFailure === true) {
            $this->transRollback();
            if ($this->transStrict === false) {
                $this->transStatus = true;
            }
            return false;
        }
        return $this->transCommit();
    }

    public function transRollback(): bool
    {
        if (!$this->transEnabled || $this->transDepth === 0) {
            return false;
        }
        if ($this->transDepth > 1 || $this->_transRollback()) {
            $this->transDepth--;
            return true;
        }
        return false;
    }

    abstract protected function _transRollback(): bool;

    public function transCommit(): bool
    {
        if (!$this->transEnabled || $this->transDepth === 0) {
            return false;
        }
        if ($this->transDepth > 1 || $this->_transCommit()) {
            $this->transDepth--;
            return true;
        }
        return false;
    }

    abstract protected function _transCommit(): bool;

    public function isWriteType($sql): bool
    {
        return (bool)preg_match('/^\s*"?(SET|INSERT|UPDATE|DELETE|REPLACE|CREATE|DROP|TRUNCATE|LOAD|COPY|ALTER|RENAME|GRANT|REVOKE|LOCK|UNLOCK|REINDEX|MERGE)\s/i', $sql);
    }

    public function resetDataCache()
    {
        $this->dataCache = [];
        return $this;
    }

    public function fieldExists(string $fieldName, string $tableName): bool
    {
        return in_array($fieldName, $this->getFieldNames($tableName), true);
    }

    public function getFieldNames(string $table)
    {
        if (isset($this->dataCache['field_names'][$table])) {
            return $this->dataCache['field_names'][$table];
        }
        if (empty($this->connID)) {
            $this->initialize();
        }
        if (false === ($sql = $this->_listColumns($table))) {
            if ($this->DBDebug) {
                throw new DatabaseException('This feature is not available for the database you are using.');
            }
            return false;
        }
        $query = $this->query($sql);
        $this->dataCache['field_names'][$table] = [];
        foreach ($query->getResultArray() as $row) {
            if (!isset($key)) {
                if (isset($row['column_name'])) {
                    $key = 'column_name';
                } elseif (isset($row['COLUMN_NAME'])) {
                    $key = 'COLUMN_NAME';
                } else {
                    $key = key($row);
                }
            }
            $this->dataCache['field_names'][$table][] = $row[$key];
        }
        return $this->dataCache['field_names'][$table];
    }

    abstract protected function _listColumns(string $table = '');

    public function getFieldData(string $table)
    {
        return $this->_fieldData($this->protectIdentifiers($table, true, false, false));
    }

    abstract protected function _fieldData(string $table): array;

    public function getIndexData(string $table)
    {
        return $this->_indexData($this->protectIdentifiers($table, true, false, false));
    }

    abstract protected function _indexData(string $table): array;

    public function getForeignKeyData(string $table)
    {
        return $this->_foreignKeyData($this->protectIdentifiers($table, true, false, false));
    }

    abstract protected function _foreignKeyData(string $table): array;

    public function disableForeignKeyChecks()
    {
        $sql = $this->_disableForeignKeyChecks();
        if ($sql === '') {
            return false;
        }
        return $this->query($sql);
    }

    protected function _disableForeignKeyChecks()
    {
        return '';
    }

    public function enableForeignKeyChecks()
    {
        $sql = $this->_enableForeignKeyChecks();
        if ($sql === '') {
            return false;
        }
        return $this->query($sql);
    }

    protected function _enableForeignKeyChecks()
    {
        return '';
    }

    abstract public function error(): array;

    abstract public function insertID();

    public function __get(string $key)
    {
        if (property_exists($this, $key)) {
            return $this->{$key};
        }
        return null;
    }

    public function __isset(string $key): bool
    {
        return property_exists($this, $key);
    }

    protected function foreignKeyDataToObjects(array $data)
    {
        $retVal = [];
        foreach ($data as $row) {
            $name = $row['constraint_name'];
            if ($name === null) {
                $name = $row['table_name'] . '_' . implode('_', $row['column_name']) . '_foreign';
            }
            $obj = new stdClass();
            $obj->constraint_name = $name;
            $obj->table_name = $row['table_name'];
            $obj->column_name = $row['column_name'];
            $obj->foreign_table_name = $row['foreign_table_name'];
            $obj->foreign_column_name = $row['foreign_column_name'];
            $obj->on_delete = $row['on_delete'];
            $obj->on_update = $row['on_update'];
            $obj->match = $row['match'];
            $retVal[$name] = $obj;
        }
        return $retVal;
    }
}