<?php

namespace Higgs\Entity;

use Higgs\Entity\Cast\ArrayCast;
use Higgs\Entity\Cast\BooleanCast;
use Higgs\Entity\Cast\CastInterface;
use Higgs\Entity\Cast\CSVCast;
use Higgs\Entity\Cast\DatetimeCast;
use Higgs\Entity\Cast\FloatCast;
use Higgs\Entity\Cast\IntBoolCast;
use Higgs\Entity\Cast\IntegerCast;
use Higgs\Entity\Cast\JsonCast;
use Higgs\Entity\Cast\ObjectCast;
use Higgs\Entity\Cast\StringCast;
use Higgs\Entity\Cast\TimestampCast;
use Higgs\Entity\Cast\URICast;
use Higgs\Entity\Exceptions\CastException;
use Higgs\I18n\Time;
use DateTime;
use Exception;
use JsonSerializable;
use ReturnTypeWillChange;

class Entity implements JsonSerializable
{
    protected $datamap = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at',];
    protected $casts = [];
    protected $castHandlers = [];
    protected $attributes = [];
    protected $original = [];
    private array $defaultCastHandlers = ['array' => ArrayCast::class, 'bool' => BooleanCast::class, 'boolean' => BooleanCast::class, 'csv' => CSVCast::class, 'datetime' => DatetimeCast::class, 'double' => FloatCast::class, 'float' => FloatCast::class, 'int' => IntegerCast::class, 'integer' => IntegerCast::class, 'int-bool' => IntBoolCast::class, 'json' => JsonCast::class, 'object' => ObjectCast::class, 'string' => StringCast::class, 'timestamp' => TimestampCast::class, 'uri' => URICast::class,];
    private bool $_cast = true;

    public function __construct(?array $data = null)
    {
        $this->syncOriginal();
        $this->fill($data);
    }

    public function syncOriginal()
    {
        $this->original = $this->attributes;
        return $this;
    }

    public function fill(?array $data = null)
    {
        if (!is_array($data)) {
            return $this;
        }
        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }
        return $this;
    }

    public function toRawArray(bool $onlyChanged = false, bool $recursive = false): array
    {
        $return = [];
        if (!$onlyChanged) {
            if ($recursive) {
                return array_map(static function ($value) use ($onlyChanged, $recursive) {
                    if ($value instanceof self) {
                        $value = $value->toRawArray($onlyChanged, $recursive);
                    } elseif (is_callable([$value, 'toRawArray'])) {
                        $value = $value->toRawArray();
                    }
                    return $value;
                }, $this->attributes);
            }
            return $this->attributes;
        }
        foreach ($this->attributes as $key => $value) {
            if (!$this->hasChanged($key)) {
                continue;
            }
            if ($recursive) {
                if ($value instanceof self) {
                    $value = $value->toRawArray($onlyChanged, $recursive);
                } elseif (is_callable([$value, 'toRawArray'])) {
                    $value = $value->toRawArray();
                }
            }
            $return[$key] = $value;
        }
        return $return;
    }

    public function hasChanged(?string $key = null): bool
    {
        if ($key === null) {
            return $this->original !== $this->attributes;
        }
        $key = $this->mapProperty($key);
        if (!array_key_exists($key, $this->original) && !array_key_exists($key, $this->attributes)) {
            return false;
        }
        if (!array_key_exists($key, $this->original) && array_key_exists($key, $this->attributes)) {
            return true;
        }
        return $this->original[$key] !== $this->attributes[$key];
    }

    protected function mapProperty(string $key)
    {
        if (empty($this->datamap)) {
            return $key;
        }
        if (!empty($this->datamap[$key])) {
            return $this->datamap[$key];
        }
        return $key;
    }

    public function setAttributes(array $data)
    {
        $this->attributes = $data;
        $this->syncOriginal();
        return $this;
    }

    #[ReturnTypeWillChange] public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray(bool $onlyChanged = false, bool $cast = true, bool $recursive = false): array
    {
        $this->_cast = $cast;
        $keys = array_filter(array_keys($this->attributes), static fn($key) => strpos($key, '_') !== 0);
        if (is_array($this->datamap)) {
            $keys = array_unique([...array_diff($keys, $this->datamap), ...array_keys($this->datamap)]);
        }
        $return = [];
        foreach ($keys as $key) {
            if ($onlyChanged && !$this->hasChanged($key)) {
                continue;
            }
            $return[$key] = $this->__get($key);
            if ($recursive) {
                if ($return[$key] instanceof self) {
                    $return[$key] = $return[$key]->toArray($onlyChanged, $cast, $recursive);
                } elseif (is_callable([$return[$key], 'toArray'])) {
                    $return[$key] = $return[$key]->toArray();
                }
            }
        }
        $this->_cast = true;
        return $return;
    }

    public function __get(string $key)
    {
        $key = $this->mapProperty($key);
        $result = null;
        $method = 'get' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $key)));
        if (method_exists($this, $method)) {
            $result = $this->{$method}();
        } elseif (array_key_exists($key, $this->attributes)) {
            $result = $this->attributes[$key];
        }
        if (in_array($key, $this->dates, true)) {
            $result = $this->mutateDate($result);
        } elseif ($this->_cast) {
            $result = $this->castAs($result, $key);
        }
        return $result;
    }

    public function __set(string $key, $value = null)
    {
        $key = $this->mapProperty($key);
        if (in_array($key, $this->dates, true)) {
            $value = $this->mutateDate($value);
        }
        $value = $this->castAs($value, $key, 'set');
        $method = 'set' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $key)));
        if (method_exists($this, $method)) {
            $this->{$method}($value);
            return $this;
        }
        $this->attributes[$key] = $value;
        return $this;
    }

    protected function mutateDate($value)
    {
        return DatetimeCast::get($value);
    }

    protected function castAs($value, string $attribute, string $method = 'get')
    {
        if (empty($this->casts[$attribute])) {
            return $value;
        }
        $type = $this->casts[$attribute];
        $isNullable = false;
        if (strpos($type, '?') === 0) {
            $isNullable = true;
            if ($value === null) {
                return null;
            }
            $type = substr($type, 1);
        }
        $type = $type === 'json-array' ? 'json[array]' : $type;
        if (!in_array($method, ['get', 'set'], true)) {
            throw CastException::forInvalidMethod($method);
        }
        $params = [];
        if (preg_match('/^(.+)\[(.+)\]$/', $type, $matches)) {
            $type = $matches[1];
            $params = array_map('trim', explode(',', $matches[2]));
        }
        if ($isNullable) {
            $params[] = 'nullable';
        }
        $type = trim($type, '[]');
        $handlers = array_merge($this->defaultCastHandlers, $this->castHandlers);
        if (empty($handlers[$type])) {
            return $value;
        }
        if (!is_subclass_of($handlers[$type], CastInterface::class)) {
            throw CastException::forInvalidInterface($handlers[$type]);
        }
        return $handlers[$type]::$method($value, $params);
    }

    public function cast(?bool $cast = null)
    {
        if ($cast === null) {
            return $this->_cast;
        }
        $this->_cast = $cast;
        return $this;
    }

    public function __isset(string $key): bool
    {
        if ($this->isMappedDbColumn($key)) {
            return false;
        }
        $key = $this->mapProperty($key);
        $method = 'get' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $key)));
        if (method_exists($this, $method)) {
            return true;
        }
        return isset($this->attributes[$key]);
    }

    protected function isMappedDbColumn(string $key): bool
    {
        $maybeColumnName = $this->mapProperty($key);
        if ($key !== $maybeColumnName) {
            return false;
        }
        return $this->hasMappedProperty($key);
    }

    protected function hasMappedProperty(string $key): bool
    {
        $property = array_search($key, $this->datamap, true);
        return $property !== false;
    }

    public function __unset(string $key): void
    {
        if ($this->isMappedDbColumn($key)) {
            return;
        }
        $key = $this->mapProperty($key);
        unset($this->attributes[$key]);
    }
}