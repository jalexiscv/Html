<?php

class Smarty_CacheResource_Pdo extends Smarty_CacheResource_Custom
{
    protected $fetchStatements = array('default' => 'SELECT %2$s
                                                                                    FROM %1$s 
                                                                                    WHERE 1 
                                                                                    AND id          = :id 
                                                                                    AND cache_id    IS NULL 
                                                                                    AND compile_id  IS NULL', 'withCacheId' => 'SELECT %2$s
                                                                                FROM %1$s 
                                                                                WHERE 1 
                                                                                AND id          = :id 
                                                                                AND cache_id    = :cache_id 
                                                                                AND compile_id  IS NULL', 'withCompileId' => 'SELECT %2$s
                                                                                FROM %1$s 
                                                                                WHERE 1 
                                                                                AND id          = :id 
                                                                                AND compile_id  = :compile_id 
                                                                                AND cache_id    IS NULL', 'withCacheIdAndCompileId' => 'SELECT %2$s
                                                                                FROM %1$s 
                                                                                WHERE 1 
                                                                                AND id          = :id 
                                                                                AND cache_id    = :cache_id 
                                                                                AND compile_id  = :compile_id');
    protected $insertStatement = 'INSERT INTO %s

                                                SET id          =   :id, 
                                                    name        =   :name, 
                                                    cache_id    =   :cache_id, 
                                                    compile_id  =   :compile_id, 
                                                    modified    =   CURRENT_TIMESTAMP, 
                                                    expire      =   DATE_ADD(CURRENT_TIMESTAMP, INTERVAL :expire SECOND), 
                                                    content     =   :content 

                                                ON DUPLICATE KEY UPDATE 
                                                    name        =   :name, 
                                                    cache_id    =   :cache_id, 
                                                    compile_id  =   :compile_id, 
                                                    modified    =   CURRENT_TIMESTAMP, 
                                                    expire      =   DATE_ADD(CURRENT_TIMESTAMP, INTERVAL :expire SECOND), 
                                                    content     =   :content';
    protected $deleteStatement = 'DELETE FROM %1$s WHERE %2$s';
    protected $truncateStatement = 'TRUNCATE TABLE %s';
    protected $fetchColumns = 'modified, content';
    protected $fetchTimestampColumns = 'modified';
    protected $pdo;
    protected $table;
    protected $database;

    public function __construct(PDO $pdo, $table, $database = null)
    {
        if (is_null($table)) {
            throw new SmartyException("Table name for caching can't be null");
        }
        $this->pdo = $pdo;
        $this->table = $table;
        $this->database = $database;
        $this->fillStatementsWithTableName();
    }

    protected function fillStatementsWithTableName()
    {
        foreach ($this->fetchStatements as &$statement) {
            $statement = sprintf($statement, $this->getTableName(), '%s');
        }
        $this->insertStatement = sprintf($this->insertStatement, $this->getTableName());
        $this->deleteStatement = sprintf($this->deleteStatement, $this->getTableName(), '%s');
        $this->truncateStatement = sprintf($this->truncateStatement, $this->getTableName());
        return $this;
    }

    protected function getFetchStatement($columns, $id, $cache_id = null, $compile_id = null)
    {
        $args = array();
        if (!is_null($cache_id) && !is_null($compile_id)) {
            $query = $this->fetchStatements['withCacheIdAndCompileId'] and $args = array('id' => $id, 'cache_id' => $cache_id, 'compile_id' => $compile_id);
        } elseif (is_null($cache_id) && !is_null($compile_id)) {
            $query = $this->fetchStatements['withCompileId'] and $args = array('id' => $id, 'compile_id' => $compile_id);
        } elseif (!is_null($cache_id) && is_null($compile_id)) {
            $query = $this->fetchStatements['withCacheId'] and $args = array('id' => $id, 'cache_id' => $cache_id);
        } else {
            $query = $this->fetchStatements['default'] and $args = array('id' => $id);
        }
        $query = sprintf($query, $columns);
        $stmt = $this->pdo->prepare($query);
        foreach ($args as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        return $stmt;
    }

    protected function fetch($id, $name, $cache_id, $compile_id, &$content, &$mtime)
    {
        $stmt = $this->getFetchStatement($this->fetchColumns, $id, $cache_id, $compile_id);
        $stmt->execute();
        $row = $stmt->fetch();
        $stmt->closeCursor();
        if ($row) {
            $content = $this->outputContent($row['content']);
            $mtime = strtotime($row['modified']);
        } else {
            $content = null;
            $mtime = null;
        }
    }

    protected function save($id, $name, $cache_id, $compile_id, $exp_time, $content)
    {
        $stmt = $this->pdo->prepare($this->insertStatement);
        $stmt->bindValue('id', $id);
        $stmt->bindValue('name', $name);
        $stmt->bindValue('cache_id', $cache_id, (is_null($cache_id)) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue('compile_id', $compile_id, (is_null($compile_id)) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue('expire', (int)$exp_time, PDO::PARAM_INT);
        $stmt->bindValue('content', $this->inputContent($content));
        $stmt->execute();
        return !!$stmt->rowCount();
    }

    protected function inputContent($content)
    {
        return $content;
    }

    protected function outputContent($content)
    {
        return $content;
    }

    protected function delete($name = null, $cache_id = null, $compile_id = null, $exp_time = null)
    {
        if ($name === null && $cache_id === null && $compile_id === null && $exp_time === null) {
            $this->pdo->query($this->truncateStatement);
            return -1;
        }
        $where = array();
        if ($name !== null) {
            $where[] = 'name = ' . $this->pdo->quote($name);
        }
        if ($cache_id !== null) {
            $where[] = '(cache_id = ' . $this->pdo->quote($cache_id) . ' OR cache_id LIKE ' . $this->pdo->quote($cache_id . '|%') . ')';
        }
        if ($compile_id !== null) {
            $where[] = 'compile_id = ' . $this->pdo->quote($compile_id);
        }
        if ($exp_time === Smarty::CLEAR_EXPIRED) {
            $where[] = 'expire < CURRENT_TIMESTAMP';
        } elseif ($exp_time !== null) {
            $where[] = 'modified < DATE_SUB(NOW(), INTERVAL ' . intval($exp_time) . ' SECOND)';
        }
        $query = $this->pdo->query(sprintf($this->deleteStatement, join(' AND ', $where)));
        return $query->rowCount();
    }

    protected function getTableName()
    {
        return (is_null($this->database)) ? "`{$this->table}`" : "`{$this->database}`.`{$this->table}`";
    }
}