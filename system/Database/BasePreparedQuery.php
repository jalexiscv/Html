<?php

namespace Higgs\Database;

use ArgumentCountError;
use BadMethodCallException;
use Higgs\Database\Exceptions\DatabaseException;
use Higgs\Events\Events;
use ErrorException;

abstract class BasePreparedQuery implements PreparedQueryInterface
{
    protected $statement;
    protected $errorCode;
    protected $errorString;
    protected $query;
    protected $db;

    public function __construct(BaseConnection $db)
    {
        $this->db = $db;
    }

    public function prepare(string $sql, array $options = [], string $queryClass = Query::class)
    {
        $sql = preg_replace('/:[^\s,)]+/', '?', $sql);
        $query = new $queryClass($this->db);
        $query->setQuery($sql);
        if (!empty($this->db->swapPre) && !empty($this->db->DBPrefix)) {
            $query->swapPrefix($this->db->DBPrefix, $this->db->swapPre);
        }
        $this->query = $query;
        return $this->_prepare($query->getOriginalQuery(), $options);
    }

    abstract public function _prepare(string $sql, array $options = []);

    public function execute(...$data)
    {
        $startTime = microtime(true);
        try {
            $exception = null;
            $result = $this->_execute($data);
        } catch (ArgumentCountError|ErrorException $exception) {
            $result = false;
        }
        $query = clone $this->query;
        $query->setBinds($data);
        if ($result === false) {
            $query->setDuration($startTime, $startTime);
            if ($this->db->transDepth !== 0) {
                $this->db->transStatus = false;
            }
            if ($this->db->DBDebug) {
                while ($this->db->transDepth !== 0) {
                    $transDepth = $this->db->transDepth;
                    $this->db->transComplete();
                    if ($transDepth === $this->db->transDepth) {
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
        if ($this->db->isWriteType($query)) {
            return true;
        }
        $resultClass = str_replace('PreparedQuery', 'Result', static::class);
        $resultID = $this->_getResult();
        return new $resultClass($this->db->connID, $resultID);
    }

    abstract public function _execute(array $data): bool;

    abstract public function _getResult();

    public function close(): bool
    {
        if (!isset($this->statement)) {
            throw new BadMethodCallException('Cannot call close on a non-existing prepared statement.');
        }
        try {
            return $this->_close();
        } finally {
            $this->statement = null;
        }
    }

    abstract protected function _close(): bool;

    public function getQueryString(): string
    {
        if (!$this->query instanceof QueryInterface) {
            throw new BadMethodCallException('Cannot call getQueryString on a prepared query until after the query has been prepared.');
        }
        return $this->query->getQuery();
    }

    public function hasError(): bool
    {
        return !empty($this->errorString);
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    public function getErrorMessage(): string
    {
        return $this->errorString;
    }
}