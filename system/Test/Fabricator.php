<?php

namespace Higgs\Test;

use Higgs\Exceptions\FrameworkException;
use Higgs\I18n\Time;
use Higgs\Model;
use Faker\Factory;
use Faker\Generator;
use InvalidArgumentException;
use RuntimeException;

class Fabricator
{
    protected static $tableCounts = [];
    public $defaultFormatter = 'word';
    protected $faker;
    protected $model;
    protected $locale;
    protected $formatters;
    protected $dateFields = [];
    protected $overrides = [];
    protected $tempOverrides;

    public function __construct($model, ?array $formatters = null, ?string $locale = null)
    {
        if (is_string($model)) {
            $model = model($model, false);
        }
        if (!is_object($model)) {
            throw new InvalidArgumentException(lang('Fabricator.invalidModel'));
        }
        $this->model = $model;
        if ($locale === null) {
            $locale = config('App')->defaultLocale;
        }
        $this->locale = $locale;
        $this->faker = Factory::create($this->locale);
        foreach (['createdField', 'updatedField', 'deletedField'] as $field) {
            if (!empty($this->model->{$field})) {
                $this->dateFields[] = $this->model->{$field};
            }
        }
        $this->setFormatters($formatters);
    }

    public function create(?int $count = null, bool $mock = false)
    {
        if ($mock) {
            return $this->createMock($count);
        }
        $ids = [];
        foreach ($this->make($count ?? 1) as $result) {
            if ($id = $this->model->insert($result, true)) {
                $ids[] = $id;
                self::upCount($this->model->table);
                continue;
            }
            throw FrameworkException::forFabricatorCreateFailed($this->model->table, implode(' ', $this->model->errors() ?? []));
        }
        if (method_exists($this->model, 'withDeleted')) {
            $this->model->withDeleted();
        }
        return $this->model->find($count === null ? reset($ids) : $ids);
    }

    protected function createMock(?int $count = null)
    {
        switch ($this->model->dateFormat) {
            case 'datetime':
                $datetime = date('Y-m-d H:i:s');
                break;
            case 'date':
                $datetime = date('Y-m-d');
                break;
            default:
                $datetime = Time::now()->getTimestamp();
        }
        $fields = [];
        if (!empty($this->model->useTimestamps)) {
            $fields[$this->model->createdField] = $datetime;
            $fields[$this->model->updatedField] = $datetime;
        }
        if (!empty($this->model->useSoftDeletes)) {
            $fields[$this->model->deletedField] = null;
        }
        $return = [];
        foreach ($this->make($count ?? 1) as $i => $result) {
            $fields[$this->model->primaryKey] = $i;
            if (is_array($result)) {
                $result = array_merge($result, $fields);
            } else {
                foreach ($fields as $key => $value) {
                    $result->{$key} = $value;
                }
            }
            $return[] = $result;
        }
        return $count === null ? reset($return) : $return;
    }

    public function make(?int $count = null)
    {
        if ($count === null) {
            return $this->model->returnType === 'array' ? $this->makeArray() : $this->makeObject();
        }
        $return = [];
        for ($i = 0; $i < $count; $i++) {
            $return[] = $this->model->returnType === 'array' ? $this->makeArray() : $this->makeObject();
        }
        return $return;
    }

    public function makeArray()
    {
        if ($this->formatters !== null) {
            $result = [];
            foreach ($this->formatters as $field => $formatter) {
                $result[$field] = $this->faker->{$formatter}();
            }
        } elseif (method_exists($this->model, 'fake')) {
            $result = $this->model->fake($this->faker);
            $result = is_object($result) && method_exists($result, 'toArray') ? $result->toArray() : (array)$result;
        } else {
            throw new RuntimeException(lang('Fabricator.missingFormatters'));
        }
        return array_merge($result, $this->getOverrides());
    }

    public function getOverrides(): array
    {
        $overrides = $this->tempOverrides ?? $this->overrides;
        $this->tempOverrides = $this->overrides;
        return $overrides;
    }

    public function setOverrides(array $overrides = [], $persist = true): self
    {
        if ($persist) {
            $this->overrides = $overrides;
        }
        $this->tempOverrides = $overrides;
        return $this;
    }

    public function makeObject(?string $className = null): object
    {
        if ($className === null) {
            if ($this->model->returnType === 'object' || $this->model->returnType === 'array') {
                $className = 'stdClass';
            } else {
                $className = $this->model->returnType;
            }
        }
        if ($this->formatters === null && method_exists($this->model, 'fake')) {
            $result = $this->model->fake($this->faker);
            if ($result instanceof $className) {
                foreach ($this->getOverrides() as $key => $value) {
                    $result->{$key} = $value;
                }
                return $result;
            }
        }
        $array = $this->makeArray();
        $object = new $className();
        if (method_exists($object, 'fill')) {
            $object->fill($array);
        } else {
            foreach ($array as $key => $value) {
                $object->{$key} = $value;
            }
        }
        return $object;
    }

    public static function upCount(string $table): int
    {
        return self::setCount($table, self::getCount($table) + 1);
    }

    public static function setCount(string $table, int $count): int
    {
        self::$tableCounts[$table] = $count;
        return $count;
    }

    public static function getCount(string $table): int
    {
        return empty(self::$tableCounts[$table]) ? 0 : self::$tableCounts[$table];
    }

    public static function resetCounts()
    {
        self::$tableCounts = [];
    }

    public static function downCount(string $table): int
    {
        return self::setCount($table, self::getCount($table) - 1);
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getFaker(): Generator
    {
        return $this->faker;
    }

    public function getFormatters(): ?array
    {
        return $this->formatters;
    }

    public function setFormatters(?array $formatters = null): self
    {
        if ($formatters !== null) {
            $this->formatters = $formatters;
        } elseif (method_exists($this->model, 'fake')) {
            $this->formatters = null;
        } else {
            $this->detectFormatters();
        }
        return $this;
    }

    protected function detectFormatters(): self
    {
        $this->formatters = [];
        if (!empty($this->model->allowedFields)) {
            foreach ($this->model->allowedFields as $field) {
                $this->formatters[$field] = $this->guessFormatter($field);
            }
        }
        return $this;
    }

    protected function guessFormatter($field): string
    {
        try {
            $this->faker->getFormatter($field);
            return $field;
        } catch (InvalidArgumentException $e) {
        }
        if (in_array($field, $this->dateFields, true)) {
            switch ($this->model->dateFormat) {
                case 'datetime':
                case 'date':
                    return 'date';
                case 'int':
                    return 'unixTime';
            }
        } elseif ($field === $this->model->primaryKey) {
            return 'numberBetween';
        }
        foreach (['email', 'name', 'title', 'text', 'date', 'url'] as $term) {
            if (stripos($field, $term) !== false) {
                return $term;
            }
        }
        if (stripos($field, 'phone') !== false) {
            return 'phoneNumber';
        }
        return $this->defaultFormatter;
    }
}