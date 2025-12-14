<?php

namespace Higgs;

use BadMethodCallException;
use Closure;
use Higgs\Database\BaseBuilder;
use Higgs\Database\BaseConnection;
use Higgs\Database\BaseResult;
use Higgs\Database\ConnectionInterface;
use Higgs\Database\Exceptions\DatabaseException;
use Higgs\Database\Exceptions\DataException;
use Higgs\Database\Query;
use Higgs\Exceptions\ModelException;
use Higgs\I18n\Time;
use Higgs\Validation\ValidationInterface;
use Config\Database;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class Model extends BaseModel
{
    protected $table;
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $builder;
    protected $tempData = [];
    protected $escape = [];
    private $tempPrimaryKeyValue;
    private array $builderMethodsNotAvailable = ['getCompiledInsert', 'getCompiledSelect', 'getCompiledUpdate',];

    public function __construct(?ConnectionInterface $db = null, ?ValidationInterface $validation = null)
    {
        $db ??= Database::connect($this->DBGroup);
        $this->db = $db;
        parent::__construct($validation);
    }

    public static function classToArray($data, $primaryKey = null, string $dateFormat = 'datetime', bool $onlyChanged = true): array
    {
        if (method_exists($data, 'toRawArray')) {
            $properties = $data->toRawArray($onlyChanged);
            if (!empty($properties) && !empty($primaryKey) && !in_array($primaryKey, $properties, true) && !empty($data->{$primaryKey})) {
                $properties[$primaryKey] = $data->{$primaryKey};
            }
        } else {
            $mirror = new ReflectionClass($data);
            $props = $mirror->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);
            $properties = [];
            foreach ($props as $prop) {
                $prop->setAccessible(true);
                $properties[$prop->getName()] = $prop->getValue($data);
            }
        }
        if ($properties) {
            foreach ($properties as $key => $value) {
                if ($value instanceof Time) {
                    switch ($dateFormat) {
                        case 'datetime':
                            $converted = $value->format('Y-m-d H:i:s');
                            break;
                        case 'date':
                            $converted = $value->format('Y-m-d');
                            break;
                        case 'int':
                            $converted = $value->getTimestamp();
                            break;
                        default:
                            $converted = (string)$value;
                    }
                    $properties[$key] = $converted;
                }
            }
        }
        return $properties;
    }

    public function setTable(string $table)
    {
        $this->table = $table;
        return ($this);
    }

    public function chunk(int $size, Closure $userFunc)
    {
        $total = $this->builder()->countAllResults(false);
        $offset = 0;
        while ($offset <= $total) {
            $builder = clone $this->builder();
            $rows = $builder->get($size, $offset);
            if (!$rows) {
                throw DataException::forEmptyDataset('chunk');
            }
            $rows = $rows->getResult($this->tempReturnType);
            $offset += $size;
            if (empty($rows)) {
                continue;
            }
            foreach ($rows as $row) {
                if ($userFunc($row) === false) {
                    return;
                }
            }
        }
    }

    public function countAllResults(bool $reset = true, bool $test = false)
    {
        if ($this->tempUseSoftDeletes) {
            $this->builder()->where($this->table . '.' . $this->deletedField, null);
        }
        $this->tempUseSoftDeletes = $reset ? $this->useSoftDeletes : ($this->useSoftDeletes ? false : $this->useSoftDeletes);
        return $this->builder()->testMode($test)->countAllResults($reset);
    }

    public function builder(?string $table = null)
    {
        if ($this->builder instanceof BaseBuilder) {
            if ($table && $this->builder->getTable() !== $table) {
                return $this->db->table($table);
            }
            return $this->builder;
        }
        if (empty($this->primaryKey)) {
            throw ModelException::forNoPrimaryKey(static::class);
        }
        $table = empty($table) ? $this->table : $table;
        if (!$this->db instanceof BaseConnection) {
            $this->db = Database::connect($this->DBGroup);
        }
        $builder = $this->db->table($table);
        if ($table === $this->table) {
            $this->builder = $builder;
        }
        return $builder;
    }

    public function __get(string $name)
    {
        if (parent::__isset($name)) {
            return parent::__get($name);
        }
        if (isset($this->builder()->{$name})) {
            return $this->builder()->{$name};
        }
        return null;
    }

    public function __isset(string $name): bool
    {
        if (parent::__isset($name)) {
            return true;
        }
        return isset($this->builder()->{$name});
    }

    public function __call(string $name, array $params)
    {
        $builder = $this->builder();
        $result = null;
        if (method_exists($this->db, $name)) {
            $result = $this->db->{$name}(...$params);
        } elseif (method_exists($builder, $name)) {
            $this->checkBuilderMethod($name);
            $result = $builder->{$name}(...$params);
        } else {
            throw new BadMethodCallException('Call to undefined method ' . static::class . '::' . $name);
        }
        if ($result instanceof BaseBuilder) {
            return $this;
        }
        return $result;
    }

    private function checkBuilderMethod(string $name): void
    {
        if (in_array($name, $this->builderMethodsNotAvailable, true)) {
            throw ModelException::forMethodNotAvailable(static::class, $name . '()');
        }
    }

    protected function doFind(bool $singleton, $id = null)
    {
        $builder = $this->builder();
        if ($this->tempUseSoftDeletes) {
            $builder->where($this->table . '.' . $this->deletedField, null);
        }
        if (is_array($id)) {
            $row = $builder->whereIn($this->table . '.' . $this->primaryKey, $id)->get()->getResult($this->tempReturnType);
        } elseif ($singleton) {
            $row = $builder->where($this->table . '.' . $this->primaryKey, $id)->get()->getFirstRow($this->tempReturnType);
        } else {
            $row = $builder->get()->getResult($this->tempReturnType);
        }
        return $row;
    }

    protected function doFindColumn(string $columnName)
    {
        return $this->select($columnName)->asArray()->find();
    }

    protected function doFindAll(int $limit = 0, int $offset = 0)
    {
        $builder = $this->builder();
        if ($this->tempUseSoftDeletes) {
            $builder->where($this->table . '.' . $this->deletedField, null);
        }
        return $builder->limit($limit, $offset)->get()->getResult($this->tempReturnType);
    }

    protected function doFirst()
    {
        $builder = $this->builder();
        if ($this->tempUseSoftDeletes) {
            $builder->where($this->table . '.' . $this->deletedField, null);
        } elseif ($this->useSoftDeletes && empty($builder->QBGroupBy) && $this->primaryKey) {
            $builder->groupBy($this->table . '.' . $this->primaryKey);
        }
        if ($builder->QBGroupBy && empty($builder->QBOrderBy) && $this->primaryKey) {
            $builder->orderBy($this->table . '.' . $this->primaryKey, 'asc');
        }
        return $builder->limit(1, 0)->get()->getFirstRow($this->tempReturnType);
    }

    protected function doInsert(array $data)
    {
        $escape = $this->escape;
        $this->escape = [];
        if ($this->useAutoIncrement === false && $this->tempPrimaryKeyValue !== null) {
            $data[$this->primaryKey] = $this->tempPrimaryKeyValue;
            $this->tempPrimaryKeyValue = null;
        }
        if (!$this->useAutoIncrement && empty($data[$this->primaryKey])) {
            throw DataException::forEmptyPrimaryKey('insert');
        }
        $builder = $this->builder();
        foreach ($data as $key => $val) {
            $builder->set($key, $val, $escape[$key] ?? null);
        }
        if ($this->allowEmptyInserts && empty($data)) {
            $table = $this->db->protectIdentifiers($this->table, true, null, false);
            if ($this->db->getPlatform() === 'MySQLi') {
                $sql = 'INSERT INTO ' . $table . ' VALUES ()';
            } elseif ($this->db->getPlatform() === 'OCI8') {
                $allFields = $this->db->protectIdentifiers(array_map(static fn($row) => $row->name, $this->db->getFieldData($this->table)), false, true);
                $sql = sprintf('INSERT INTO %s (%s) VALUES (%s)', $table, implode(',', $allFields), substr(str_repeat(',DEFAULT', count($allFields)), 1));
            } else {
                $sql = 'INSERT INTO ' . $table . ' DEFAULT VALUES';
            }
            $result = $this->db->query($sql);
        } else {
            $result = $builder->insert();
        }
        if ($result) {
            $this->insertID = !$this->useAutoIncrement ? $data[$this->primaryKey] : $this->db->insertID();
        }
        return $result;
    }

    public function set($key, $value = '', ?bool $escape = null)
    {
        $data = is_array($key) ? $key : [$key => $value];
        foreach (array_keys($data) as $k) {
            $this->tempData['escape'][$k] = $escape;
        }
        $this->tempData['data'] = array_merge($this->tempData['data'] ?? [], $data);
        return $this;
    }

    public function insert($data = null, bool $returnID = true)
    {
        if (!empty($this->tempData['data'])) {
            if (empty($data)) {
                $data = $this->tempData['data'];
            } else {
                $data = $this->transformDataToArray($data, 'insert');
                $data = array_merge($this->tempData['data'], $data);
            }
        }
        if ($this->useAutoIncrement === false) {
            if (is_array($data) && isset($data[$this->primaryKey])) {
                $this->tempPrimaryKeyValue = $data[$this->primaryKey];
            } elseif (is_object($data) && isset($data->{$this->primaryKey})) {
                $this->tempPrimaryKeyValue = $data->{$this->primaryKey};
            }
        }
        $this->escape = $this->tempData['escape'] ?? [];
        $this->tempData = [];
        return parent::insert($data, $returnID);
    }

    protected function doInsertBatch(?array $set = null, ?bool $escape = null, int $batchSize = 100, bool $testing = false)
    {
        if (is_array($set)) {
            foreach ($set as $row) {
                if (!$this->useAutoIncrement && empty($row[$this->primaryKey])) {
                    throw DataException::forEmptyPrimaryKey('insertBatch');
                }
            }
        }
        return $this->builder()->testMode($testing)->insertBatch($set, $escape, $batchSize);
    }

    protected function doUpdate($id = null, $data = null): bool
    {
        $escape = $this->escape;
        $this->escape = [];
        $builder = $this->builder();
        if ($id) {
            $builder = $builder->whereIn($this->table . '.' . $this->primaryKey, $id);
        }
        foreach ($data as $key => $val) {
            $builder->set($key, $val, $escape[$key] ?? null);
        }
        if ($builder->getCompiledQBWhere() === []) {
            throw new DatabaseException('Updates are not allowed unless they contain a "where" or "like" clause.');
        }
        return $builder->update();
    }

    public function update($id = null, $data = null): bool
    {
        if (!empty($this->tempData['data'])) {
            if (empty($data)) {
                $data = $this->tempData['data'];
            } else {
                $data = $this->transformDataToArray($data, 'update');
                $data = array_merge($this->tempData['data'], $data);
            }
        }
        $this->escape = $this->tempData['escape'] ?? [];
        $this->tempData = [];
        return parent::update($id, $data);
    }

    protected function doUpdateBatch(?array $set = null, ?string $index = null, int $batchSize = 100, bool $returnSQL = false)
    {
        return $this->builder()->testMode($returnSQL)->updateBatch($set, $index, $batchSize);
    }

    protected function doDelete($id = null, bool $purge = false)
    {
        $builder = $this->builder();
        if ($id) {
            $builder = $builder->whereIn($this->primaryKey, $id);
        }
        if ($this->useSoftDeletes && !$purge) {
            if (empty($builder->getCompiledQBWhere())) {
                throw new DatabaseException('Deletes are not allowed unless they contain a "where" or "like" clause.');
            }
            $builder->where($this->deletedField);
            $set[$this->deletedField] = $this->setDate();
            if ($this->useTimestamps && $this->updatedField) {
                $set[$this->updatedField] = $this->setDate();
            }
            return $builder->update($set);
        }
        return $builder->delete();
    }

    protected function doPurgeDeleted()
    {
        return $this->builder()->where($this->table . '.' . $this->deletedField . ' IS NOT NULL')->delete();
    }

    protected function doOnlyDeleted()
    {
        $this->builder()->where($this->table . '.' . $this->deletedField . ' IS NOT NULL');
    }

    protected function doReplace(?array $data = null, bool $returnSQL = false)
    {
        return $this->builder()->testMode($returnSQL)->replace($data);
    }

    protected function doErrors()
    {
        $error = $this->db->error();
        if ((int)$error['code'] === 0) {
            return [];
        }
        return [get_class($this->db) => $error['message']];
    }

    protected function idValue($data)
    {
        return $this->getIdValue($data);
    }

    public function getIdValue($data)
    {
        if (is_object($data) && isset($data->{$this->primaryKey})) {
            return $data->{$this->primaryKey};
        }
        if (is_array($data) && !empty($data[$this->primaryKey])) {
            return $data[$this->primaryKey];
        }
        return null;
    }

    protected function shouldUpdate($data): bool
    {
        if (parent::shouldUpdate($data) === false) {
            return false;
        }
        if ($this->useAutoIncrement === true) {
            return true;
        }
        return $this->where($this->primaryKey, $this->getIdValue($data))->countAllResults() === 1;
    }

    protected function objectToRawArray($data, bool $onlyChanged = true, bool $recursive = false): ?array
    {
        $properties = parent::objectToRawArray($data, $onlyChanged);
        if (method_exists($data, 'toRawArray') && (!empty($properties) && !empty($this->primaryKey) && !in_array($this->primaryKey, $properties, true) && !empty($data->{$this->primaryKey}))) {
            $properties[$this->primaryKey] = $data->{$this->primaryKey};
        }
        return $properties;
    }
}