<?php

namespace Higgs;

use Closure;
use Higgs\Database\BaseConnection;
use Higgs\Database\BaseResult;
use Higgs\Database\Exceptions\DatabaseException;
use Higgs\Database\Exceptions\DataException;
use Higgs\Database\Query;
use Higgs\Exceptions\ModelException;
use Higgs\I18n\Time;
use Higgs\Pager\Pager;
use Higgs\Validation\ValidationInterface;
use Config\Services;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use stdClass;

abstract class BaseModel
{
    public $pager;
    protected $insertID = 0;
    protected $DBGroup;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [];
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $tempUseSoftDeletes;
    protected $deletedField = 'deleted_at';
    protected $tempReturnType;
    protected $protectFields = true;
    protected $db;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
    protected $validation;
    protected $allowCallbacks = true;
    protected $tempAllowCallbacks;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeInsertBatch = [];
    protected $afterInsertBatch = [];
    protected $beforeUpdateBatch = [];
    protected $afterUpdateBatch = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];
    protected bool $allowEmptyInserts = false;

    public function __construct(?ValidationInterface $validation = null)
    {
        $this->tempReturnType = $this->returnType;
        $this->tempUseSoftDeletes = $this->useSoftDeletes;
        $this->tempAllowCallbacks = $this->allowCallbacks;
        $validation ??= Services::validation(null, false);
        $this->validation = $validation;
        $this->initialize();
    }

    protected function initialize()
    {
    }

    abstract public function chunk(int $size, Closure $userFunc);

    public function find($id = null)
    {
        $singleton = is_numeric($id) || is_string($id);
        if ($this->tempAllowCallbacks) {
            $eventData = $this->trigger('beforeFind', ['id' => $id, 'method' => 'find', 'singleton' => $singleton,]);
            if (!empty($eventData['returnData'])) {
                return $eventData['data'];
            }
        }
        $eventData = ['id' => $id, 'data' => $this->doFind($singleton, $id), 'method' => 'find', 'singleton' => $singleton,];
        if ($this->tempAllowCallbacks) {
            $eventData = $this->trigger('afterFind', $eventData);
        }
        $this->tempReturnType = $this->returnType;
        $this->tempUseSoftDeletes = $this->useSoftDeletes;
        $this->tempAllowCallbacks = $this->allowCallbacks;
        return $eventData['data'];
    }

    protected function trigger(string $event, array $eventData)
    {
        if (!isset($this->{$event}) || empty($this->{$event})) {
            return $eventData;
        }
        foreach ($this->{$event} as $callback) {
            if (!method_exists($this, $callback)) {
                throw DataException::forInvalidMethodTriggered($callback);
            }
            $eventData = $this->{$callback}($eventData);
        }
        return $eventData;
    }

    abstract protected function doFind(bool $singleton, $id = null);

    public function findColumn(string $columnName)
    {
        if (strpos($columnName, ',') !== false) {
            throw DataException::forFindColumnHaveMultipleColumns();
        }
        $resultSet = $this->doFindColumn($columnName);
        return $resultSet ? array_column($resultSet, $columnName) : null;
    }

    abstract protected function doFindColumn(string $columnName);

    public function first()
    {
        if ($this->tempAllowCallbacks) {
            $eventData = $this->trigger('beforeFind', ['method' => 'first', 'singleton' => true,]);
            if (!empty($eventData['returnData'])) {
                return $eventData['data'];
            }
        }
        $eventData = ['data' => $this->doFirst(), 'method' => 'first', 'singleton' => true,];
        if ($this->tempAllowCallbacks) {
            $eventData = $this->trigger('afterFind', $eventData);
        }
        $this->tempReturnType = $this->returnType;
        $this->tempUseSoftDeletes = $this->useSoftDeletes;
        $this->tempAllowCallbacks = $this->allowCallbacks;
        return $eventData['data'];
    }

    abstract protected function doFirst();

    public function save($data): bool
    {
        if (empty($data)) {
            return true;
        }
        if ($this->shouldUpdate($data)) {
            $response = $this->update($this->getIdValue($data), $data);
        } else {
            $response = $this->insert($data, false);
            if ($response !== false) {
                $response = true;
            }
        }
        return $response;
    }

    protected function shouldUpdate($data): bool
    {
        return !empty($this->getIdValue($data));
    }

    public function getIdValue($data)
    {
        return $this->idValue($data);
    }

    abstract protected function idValue($data);

    public function update($id = null, $data = null): bool
    {
        if (is_bool($id)) {
            throw new InvalidArgumentException('update(): argument #1 ($id) should not be boolean.');
        }
        if (is_numeric($id) || is_string($id)) {
            $id = [$id];
        }
        $data = $this->transformDataToArray($data, 'update');
        if (!$this->skipValidation && !$this->validate($data)) {
            return false;
        }
        $data = $this->doProtectFields($data);
        if (empty($data)) {
            throw DataException::forEmptyDataset('update');
        }
        if ($this->useTimestamps && $this->updatedField && !array_key_exists($this->updatedField, $data)) {
            $data[$this->updatedField] = $this->setDate();
        }
        $eventData = ['id' => $id, 'data' => $data,];
        if ($this->tempAllowCallbacks) {
            $eventData = $this->trigger('beforeUpdate', $eventData);
        }
        $eventData = ['id' => $id, 'data' => $eventData['data'], 'result' => $this->doUpdate($id, $eventData['data']),];
        if ($this->tempAllowCallbacks) {
            $this->trigger('afterUpdate', $eventData);
        }
        $this->tempAllowCallbacks = $this->allowCallbacks;
        return $eventData['result'];
    }

    protected function transformDataToArray($data, string $type): array
    {
        if (!in_array($type, ['insert', 'update'], true)) {
            throw new InvalidArgumentException(sprintf('Invalid type "%s" used upon transforming data to array.', $type));
        }
        if (!$this->allowEmptyInserts && empty($data)) {
            throw DataException::forEmptyDataset($type);
        }
        if (is_object($data) && !$data instanceof stdClass) {
            $onlyChanged = ($this->skipValidation === false && $this->cleanValidationRules === false) ? false : ($type === 'update');
            $data = $this->objectToArray($data, $onlyChanged, true);
        }
        if (is_object($data)) {
            $data = (array)$data;
        }
        if (!$this->allowEmptyInserts && empty($data)) {
            throw DataException::forEmptyDataset($type);
        }
        return $data;
    }

    protected function objectToArray($data, bool $onlyChanged = true, bool $recursive = false): array
    {
        $properties = $this->objectToRawArray($data, $onlyChanged, $recursive);
        if ($properties) {
            $properties = array_map(function ($value) {
                if ($value instanceof Time) {
                    return $this->timeToDate($value);
                }
                return $value;
            }, $properties);
        }
        return $properties;
    }

    protected function objectToRawArray($data, bool $onlyChanged = true, bool $recursive = false): ?array
    {
        if (method_exists($data, 'toRawArray')) {
            $properties = $data->toRawArray($onlyChanged, $recursive);
        } else {
            $mirror = new ReflectionClass($data);
            $props = $mirror->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);
            $properties = [];
            foreach ($props as $prop) {
                $prop->setAccessible(true);
                $properties[$prop->getName()] = $prop->getValue($data);
            }
        }
        return $properties;
    }

    protected function timeToDate(Time $value)
    {
        switch ($this->dateFormat) {
            case 'datetime':
                return $value->format('Y-m-d H:i:s');
            case 'date':
                return $value->format('Y-m-d');
            case 'int':
                return $value->getTimestamp();
            default:
                return (string)$value;
        }
    }

    public function validate($data): bool
    {
        $rules = $this->getValidationRules();
        if ($this->skipValidation || empty($rules) || empty($data)) {
            return true;
        }
        if (is_object($data)) {
            $data = (array)$data;
        }
        $rules = $this->cleanValidationRules ? $this->cleanValidationRules($rules, $data) : $rules;
        if (empty($rules)) {
            return true;
        }
        $this->validation->reset()->setRules($rules, $this->validationMessages);
        return $this->validation->run($data, null, $this->DBGroup);
    }

    public function getValidationRules(array $options = []): array
    {
        $rules = $this->validationRules;
        if (is_string($rules)) {
            $rules = $this->validation->loadRuleGroup($rules);
        }
        if (isset($options['except'])) {
            $rules = array_diff_key($rules, array_flip($options['except']));
        } elseif (isset($options['only'])) {
            $rules = array_intersect_key($rules, array_flip($options['only']));
        }
        return $rules;
    }

    public function setValidationRules(array $validationRules)
    {
        $this->validationRules = $validationRules;
        return $this;
    }

    protected function cleanValidationRules(array $rules, ?array $data = null): array
    {
        if (empty($data)) {
            return [];
        }
        foreach (array_keys($rules) as $field) {
            if (!array_key_exists($field, $data)) {
                unset($rules[$field]);
            }
        }
        return $rules;
    }

    protected function doProtectFields(array $data): array
    {
        if (!$this->protectFields) {
            return $data;
        }
        if (empty($this->allowedFields)) {
            throw DataException::forInvalidAllowedFields(static::class);
        }
        foreach (array_keys($data) as $key) {
            if (!in_array($key, $this->allowedFields, true)) {
                unset($data[$key]);
            }
        }
        return $data;
    }

    protected function setDate(?int $userData = null)
    {
        $currentDate = $userData ?? Time::now()->getTimestamp();
        return $this->intToDate($currentDate);
    }

    protected function intToDate(int $value)
    {
        switch ($this->dateFormat) {
            case 'int':
                return $value;
            case 'datetime':
                return date('Y-m-d H:i:s', $value);
            case 'date':
                return date('Y-m-d', $value);
            default:
                throw ModelException::forNoDateFormat(static::class);
        }
    }

    abstract protected function doUpdate($id = null, $data = null): bool;

    public function insert($data = null, bool $returnID = true)
    {
        $this->insertID = 0;
        $cleanValidationRules = $this->cleanValidationRules;
        $this->cleanValidationRules = false;
        $data = $this->transformDataToArray($data, 'insert');
        if (!$this->skipValidation && !$this->validate($data)) {
            $this->cleanValidationRules = $cleanValidationRules;
            return false;
        }
        $this->cleanValidationRules = $cleanValidationRules;
        $data = $this->doProtectFields($data);
        if (!$this->allowEmptyInserts && empty($data)) {
            throw DataException::forEmptyDataset('insert');
        }
        $date = $this->setDate();
        if ($this->useTimestamps && $this->createdField && !array_key_exists($this->createdField, $data)) {
            $data[$this->createdField] = $date;
        }
        if ($this->useTimestamps && $this->updatedField && !array_key_exists($this->updatedField, $data)) {
            $data[$this->updatedField] = $date;
        }
        $eventData = ['data' => $data];
        if ($this->tempAllowCallbacks) {
            $eventData = $this->trigger('beforeInsert', $eventData);
        }
        $result = $this->doInsert($eventData['data']);
        $eventData = ['id' => $this->insertID, 'data' => $eventData['data'], 'result' => $result,];
        if ($this->tempAllowCallbacks) {
            $this->trigger('afterInsert', $eventData);
        }
        $this->tempAllowCallbacks = $this->allowCallbacks;
        if (!$result) {
            return $result;
        }
        return $returnID ? $this->insertID : $result;
    }

    abstract protected function doInsert(array $data);

    public function getInsertID()
    {
        return is_numeric($this->insertID) ? (int)$this->insertID : $this->insertID;
    }

    public function insertBatch(?array $set = null, ?bool $escape = null, int $batchSize = 100, bool $testing = false)
    {
        $cleanValidationRules = $this->cleanValidationRules;
        $this->cleanValidationRules = false;
        if (is_array($set)) {
            foreach ($set as &$row) {
                if (is_object($row) && !$row instanceof stdClass) {
                    $row = $this->objectToArray($row, false, true);
                }
                if (is_object($row)) {
                    $row = (array)$row;
                }
                if (!$this->skipValidation && !$this->validate($row)) {
                    $this->cleanValidationRules = $cleanValidationRules;
                    return false;
                }
                $row = $this->doProtectFields($row);
                $date = $this->setDate();
                if ($this->useTimestamps && $this->createdField && !array_key_exists($this->createdField, $row)) {
                    $row[$this->createdField] = $date;
                }
                if ($this->useTimestamps && $this->updatedField && !array_key_exists($this->updatedField, $row)) {
                    $row[$this->updatedField] = $date;
                }
            }
        }
        $this->cleanValidationRules = $cleanValidationRules;
        $eventData = ['data' => $set];
        if ($this->tempAllowCallbacks) {
            $eventData = $this->trigger('beforeInsertBatch', $eventData);
        }
        $result = $this->doInsertBatch($eventData['data'], $escape, $batchSize, $testing);
        $eventData = ['data' => $eventData['data'], 'result' => $result,];
        if ($this->tempAllowCallbacks) {
            $this->trigger('afterInsertBatch', $eventData);
        }
        $this->tempAllowCallbacks = $this->allowCallbacks;
        return $result;
    }

    abstract protected function doInsertBatch(?array $set = null, ?bool $escape = null, int $batchSize = 100, bool $testing = false);

    public function updateBatch(?array $set = null, ?string $index = null, int $batchSize = 100, bool $returnSQL = false)
    {
        if (is_array($set)) {
            foreach ($set as &$row) {
                if (is_object($row) && !$row instanceof stdClass) {
                    $row = $this->objectToArray($row, true, true);
                }
                if (is_object($row)) {
                    $row = (array)$row;
                }
                if (!$this->skipValidation && !$this->validate($row)) {
                    return false;
                }
                $updateIndex = $row[$index] ?? null;
                $row = $this->doProtectFields($row);
                if ($updateIndex !== null) {
                    $row[$index] = $updateIndex;
                }
                if ($this->useTimestamps && $this->updatedField && !array_key_exists($this->updatedField, $row)) {
                    $row[$this->updatedField] = $this->setDate();
                }
            }
        }
        $eventData = ['data' => $set];
        if ($this->tempAllowCallbacks) {
            $eventData = $this->trigger('beforeUpdateBatch', $eventData);
        }
        $result = $this->doUpdateBatch($eventData['data'], $index, $batchSize, $returnSQL);
        $eventData = ['data' => $eventData['data'], 'result' => $result,];
        if ($this->tempAllowCallbacks) {
            $this->trigger('afterUpdateBatch', $eventData);
        }
        $this->tempAllowCallbacks = $this->allowCallbacks;
        return $result;
    }

    abstract protected function doUpdateBatch(?array $set = null, ?string $index = null, int $batchSize = 100, bool $returnSQL = false);

    public function delete($id = null, bool $purge = false)
    {
        if (is_bool($id)) {
            throw new InvalidArgumentException('delete(): argument #1 ($id) should not be boolean.');
        }
        if ($id && (is_numeric($id) || is_string($id))) {
            $id = [$id];
        }
        $eventData = ['id' => $id, 'purge' => $purge,];
        if ($this->tempAllowCallbacks) {
            $this->trigger('beforeDelete', $eventData);
        }
        $eventData = ['id' => $id, 'data' => null, 'purge' => $purge, 'result' => $this->doDelete($id, $purge),];
        if ($this->tempAllowCallbacks) {
            $this->trigger('afterDelete', $eventData);
        }
        $this->tempAllowCallbacks = $this->allowCallbacks;
        return $eventData['result'];
    }

    abstract protected function doDelete($id = null, bool $purge = false);

    public function purgeDeleted()
    {
        if (!$this->useSoftDeletes) {
            return true;
        }
        return $this->doPurgeDeleted();
    }

    abstract protected function doPurgeDeleted();

    public function withDeleted(bool $val = true)
    {
        $this->tempUseSoftDeletes = !$val;
        return $this;
    }

    public function onlyDeleted()
    {
        $this->tempUseSoftDeletes = false;
        $this->doOnlyDeleted();
        return $this;
    }

    abstract protected function doOnlyDeleted();

    public function replace(?array $data = null, bool $returnSQL = false)
    {
        if ($data && !$this->skipValidation && !$this->validate($data)) {
            return false;
        }
        if ($this->useTimestamps && $this->updatedField && !array_key_exists($this->updatedField, (array)$data)) {
            $data[$this->updatedField] = $this->setDate();
        }
        return $this->doReplace($data, $returnSQL);
    }

    abstract protected function doReplace(?array $data = null, bool $returnSQL = false);

    public function errors(bool $forceDB = false)
    {
        if (!$forceDB && !$this->skipValidation && ($errors = $this->validation->getErrors())) {
            return $errors;
        }
        return $this->doErrors();
    }

    abstract protected function doErrors();

    public function paginate(?int $perPage = null, string $group = 'default', ?int $page = null, int $segment = 0)
    {
        $pager = Services::pager();
        if ($segment) {
            $pager->setSegment($segment, $group);
        }
        $page = $page >= 1 ? $page : $pager->getCurrentPage($group);
        $this->pager = $pager->store($group, $page, $perPage, $this->countAllResults(false), $segment);
        $perPage = $this->pager->getPerPage($group);
        $offset = ($pager->getCurrentPage($group) - 1) * $perPage;
        return $this->findAll($perPage, $offset);
    }

    abstract public function countAllResults(bool $reset = true, bool $test = false);

    public function findAll(int $limit = 0, int $offset = 0)
    {
        if ($this->tempAllowCallbacks) {
            $eventData = $this->trigger('beforeFind', ['method' => 'findAll', 'limit' => $limit, 'offset' => $offset, 'singleton' => false,]);
            if (!empty($eventData['returnData'])) {
                return $eventData['data'];
            }
        }
        $eventData = ['data' => $this->doFindAll($limit, $offset), 'limit' => $limit, 'offset' => $offset, 'method' => 'findAll', 'singleton' => false,];
        if ($this->tempAllowCallbacks) {
            $eventData = $this->trigger('afterFind', $eventData);
        }
        $this->tempReturnType = $this->returnType;
        $this->tempUseSoftDeletes = $this->useSoftDeletes;
        $this->tempAllowCallbacks = $this->allowCallbacks;
        return $eventData['data'];
    }

    abstract protected function doFindAll(int $limit = 0, int $offset = 0);

    public function setAllowedFields(array $allowedFields)
    {
        $this->allowedFields = $allowedFields;
        return $this;
    }

    public function protect(bool $protect = true)
    {
        $this->protectFields = $protect;
        return $this;
    }

    public function skipValidation(bool $skip = true)
    {
        $this->skipValidation = $skip;
        return $this;
    }

    public function setValidationMessage(string $field, array $fieldMessages)
    {
        $this->validationMessages[$field] = $fieldMessages;
        return $this;
    }

    public function setValidationRule(string $field, $fieldRules)
    {
        $this->validationRules[$field] = $fieldRules;
        return $this;
    }

    public function cleanRules(bool $choice = false)
    {
        $this->cleanValidationRules = $choice;
        return $this;
    }

    public function getValidationMessages(): array
    {
        return $this->validationMessages;
    }

    public function setValidationMessages(array $validationMessages)
    {
        $this->validationMessages = $validationMessages;
        return $this;
    }

    public function allowCallbacks(bool $val = true)
    {
        $this->tempAllowCallbacks = $val;
        return $this;
    }

    public function asArray()
    {
        $this->tempReturnType = 'array';
        return $this;
    }

    public function asObject(string $class = 'object')
    {
        $this->tempReturnType = $class;
        return $this;
    }

    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }
        return $this->db->{$name} ?? null;
    }

    public function __isset(string $name): bool
    {
        if (property_exists($this, $name)) {
            return true;
        }
        return isset($this->db->{$name});
    }

    public function __call(string $name, array $params)
    {
        if (method_exists($this->db, $name)) {
            return $this->db->{$name}(...$params);
        }
        return null;
    }

    public function allowEmptyInserts(bool $value = true): self
    {
        $this->allowEmptyInserts = $value;
        return $this;
    }

    protected function fillPlaceholders(array $rules, array $data): array
    {
        $replacements = [];
        foreach ($data as $key => $value) {
            $replacements['{' . $key . '}'] = $value;
        }
        if (!empty($replacements)) {
            foreach ($rules as &$rule) {
                if (is_array($rule)) {
                    foreach ($rule as &$row) {
                        if (is_array($row)) {
                            continue;
                        }
                        $row = strtr($row, $replacements);
                    }
                    continue;
                }
                $rule = strtr($rule, $replacements);
            }
        }
        return $rules;
    }
}