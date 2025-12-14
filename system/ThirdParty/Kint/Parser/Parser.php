<?php
declare(strict_types=1);

namespace Kint\Parser;

use DomainException;
use Exception;
use Kint\Zval\BlobValue;
use Kint\Zval\InstanceValue;
use Kint\Zval\Representation\Representation;
use Kint\Zval\ResourceValue;
use Kint\Zval\Value;
use ReflectionObject;
use ReflectionProperty;
use stdClass;
use TypeError;

class Parser
{
    public const TRIGGER_NONE = 0;
    public const TRIGGER_BEGIN = 1;
    public const TRIGGER_SUCCESS = 2;
    public const TRIGGER_RECURSION = 4;
    public const TRIGGER_DEPTH_LIMIT = 8;
    public const TRIGGER_COMPLETE = 14;
    protected $caller_class;
    protected $depth_limit = 0;
    protected $marker;
    protected $object_hashes = [];
    protected $parse_break = false;
    protected $plugins = [];

    public function __construct(int $depth_limit = 0, ?string $caller = null)
    {
        $this->marker = "kint\0" . \random_bytes(16);
        $this->depth_limit = $depth_limit;
        $this->caller_class = $caller;
    }

    public function getCallerClass(): ?string
    {
        return $this->caller_class;
    }

    public function setCallerClass(?string $caller = null): void
    {
        $this->noRecurseCall();
        $this->caller_class = $caller;
    }

    protected function noRecurseCall(): void
    {
        $bt = \debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT | DEBUG_BACKTRACE_IGNORE_ARGS);
        $caller_frame = ['function' => __FUNCTION__,];
        while (isset($bt[0]['object']) && $bt[0]['object'] === $this) {
            $caller_frame = \array_shift($bt);
        }
        foreach ($bt as $frame) {
            if (isset($frame['object']) && $frame['object'] === $this) {
                throw new DomainException(__CLASS__ . '::' . $caller_frame['function'] . ' cannot be called from inside a parse');
            }
        }
    }

    public function getDepthLimit(): int
    {
        return $this->depth_limit;
    }

    public function setDepthLimit(int $depth_limit = 0): void
    {
        $this->noRecurseCall();
        $this->depth_limit = $depth_limit;
    }

    public function parse(&$var, Value $o): Value
    {
        $o->type = \strtolower(\gettype($var));
        if (!$this->applyPlugins($var, $o, self::TRIGGER_BEGIN)) {
            return $o;
        }
        switch ($o->type) {
            case 'array':
                return $this->parseArray($var, $o);
            case 'boolean':
            case 'double':
            case 'integer':
            case 'null':
                return $this->parseGeneric($var, $o);
            case 'object':
                return $this->parseObject($var, $o);
            case 'resource':
                return $this->parseResource($var, $o);
            case 'string':
                return $this->parseString($var, $o);
            case 'unknown type':
            case 'resource (closed)':
            default:
                return $this->parseResourceClosed($var, $o);
        }
    }

    private function applyPlugins(&$var, Value &$o, int $trigger): bool
    {
        $break_stash = $this->parse_break;
        $this->parse_break = false;
        $plugins = [];
        if (isset($this->plugins[$o->type][$trigger])) {
            $plugins = $this->plugins[$o->type][$trigger];
        }
        foreach ($plugins as $plugin) {
            try {
                $plugin->parse($var, $o, $trigger);
            } catch (Exception $e) {
                \trigger_error('An exception (' . \get_class($e) . ') was thrown in ' . $e->getFile() . ' on line ' . $e->getLine() . ' while executing Kint Parser Plugin "' . \get_class($plugin) . '". Error message: ' . $e->getMessage(), E_USER_WARNING);
            }
            if ($this->parse_break) {
                $this->parse_break = $break_stash;
                return false;
            }
        }
        $this->parse_break = $break_stash;
        return true;
    }

    private function parseArray(array &$var, Value $o): Value
    {
        $array = new Value();
        $array->transplant($o);
        $array->size = \count($var);
        if (isset($var[$this->marker])) {
            --$array->size;
            $array->hints[] = 'recursion';
            $this->applyPlugins($var, $array, self::TRIGGER_RECURSION);
            return $array;
        }
        $rep = new Representation('Contents');
        $rep->implicit_label = true;
        $array->addRepresentation($rep);
        $array->value = $rep;
        if (!$array->size) {
            $this->applyPlugins($var, $array, self::TRIGGER_SUCCESS);
            return $array;
        }
        if ($this->depth_limit && $o->depth >= $this->depth_limit) {
            $array->hints[] = 'depth_limit';
            $this->applyPlugins($var, $array, self::TRIGGER_DEPTH_LIMIT);
            return $array;
        }
        $copy = \array_values($var);
        $i = 0;
        $var[$this->marker] = $array->depth;
        $refmarker = new stdClass();
        foreach ($var as $key => &$val) {
            if ($key === $this->marker) {
                continue;
            }
            $child = new Value();
            $child->name = $key;
            $child->depth = $array->depth + 1;
            $child->access = Value::ACCESS_NONE;
            $child->operator = Value::OPERATOR_ARRAY;
            if (null !== $array->access_path) {
                if (\is_string($key) && (string)(int)$key === $key) {
                    $child->access_path = 'array_values(' . $array->access_path . ')[' . $i . ']';
                } else {
                    $child->access_path = $array->access_path . '[' . \var_export($key, true) . ']';
                }
            }
            $stash = $val;
            $copy[$i] = $refmarker;
            if ($val === $refmarker) {
                $child->reference = true;
                $val = $stash;
            }
            $rep->contents[] = $this->parse($val, $child);
            ++$i;
        }
        $this->applyPlugins($var, $array, self::TRIGGER_SUCCESS);
        unset($var[$this->marker]);
        return $array;
    }

    private function parseGeneric(&$var, Value $o): Value
    {
        $rep = new Representation('Contents');
        $rep->contents = $var;
        $rep->implicit_label = true;
        $o->addRepresentation($rep);
        $o->value = $rep;
        $this->applyPlugins($var, $o, self::TRIGGER_SUCCESS);
        return $o;
    }

    private function parseObject(&$var, Value $o): Value
    {
        $hash = \spl_object_hash($var);
        $values = (array)$var;
        $object = new InstanceValue();
        $object->transplant($o);
        $object->classname = \get_class($var);
        $object->spl_object_hash = $hash;
        $object->size = \count($values);
        if (KINT_PHP72) {
            $object->spl_object_id = \spl_object_id($var);
        }
        if (isset($this->object_hashes[$hash])) {
            $object->hints[] = 'recursion';
            $this->applyPlugins($var, $object, self::TRIGGER_RECURSION);
            return $object;
        }
        $this->object_hashes[$hash] = $object;
        if ($this->depth_limit && $o->depth >= $this->depth_limit) {
            $object->hints[] = 'depth_limit';
            $this->applyPlugins($var, $object, self::TRIGGER_DEPTH_LIMIT);
            unset($this->object_hashes[$hash]);
            return $object;
        }
        $reflector = new ReflectionObject($var);
        if ($reflector->isUserDefined()) {
            $object->filename = $reflector->getFileName();
            $object->startline = $reflector->getStartLine();
        }
        $rep = new Representation('Properties');
        $readonly = [];
        if (KINT_PHP74 && '__PHP_Incomplete_Class' != $object->classname) {
            $rprops = $reflector->getProperties();
            while ($reflector = $reflector->getParentClass()) {
                $rprops = \array_merge($rprops, $reflector->getProperties(ReflectionProperty::IS_PRIVATE));
            }
            foreach ($rprops as $rprop) {
                if ($rprop->isStatic()) {
                    continue;
                }
                $rprop->setAccessible(true);
                if (KINT_PHP81 && $rprop->isReadOnly()) {
                    if ($rprop->isPublic()) {
                        $readonly[$rprop->getName()] = true;
                    } elseif ($rprop->isProtected()) {
                        $readonly["\0*\0" . $rprop->getName()] = true;
                    } elseif ($rprop->isPrivate()) {
                        $readonly["\0" . $rprop->getDeclaringClass()->getName() . "\0" . $rprop->getName()] = true;
                    }
                }
                if ($rprop->isInitialized($var)) {
                    continue;
                }
                $undefined = null;
                $child = new Value();
                $child->type = 'undefined';
                $child->depth = $object->depth + 1;
                $child->owner_class = $rprop->getDeclaringClass()->getName();
                $child->operator = Value::OPERATOR_OBJECT;
                $child->name = $rprop->getName();
                $child->readonly = KINT_PHP81 && $rprop->isReadOnly();
                if ($rprop->isPublic()) {
                    $child->access = Value::ACCESS_PUBLIC;
                } elseif ($rprop->isProtected()) {
                    $child->access = Value::ACCESS_PROTECTED;
                } elseif ($rprop->isPrivate()) {
                    $child->access = Value::ACCESS_PRIVATE;
                }
                if ($this->childHasPath($object, $child)) {
                    $child->access_path .= $object->access_path . '->' . $child->name;
                }
                if ($this->applyPlugins($undefined, $child, self::TRIGGER_BEGIN)) {
                    $this->applyPlugins($undefined, $child, self::TRIGGER_SUCCESS);
                }
                $rep->contents[] = $child;
            }
        }
        $copy = \array_values($values);
        $refmarker = new stdClass();
        $i = 0;
        foreach ($values as $key => &$val) {
            $child = new Value();
            $child->depth = $object->depth + 1;
            $child->owner_class = $object->classname;
            $child->operator = Value::OPERATOR_OBJECT;
            $child->access = Value::ACCESS_PUBLIC;
            if (isset($readonly[$key])) {
                $child->readonly = true;
            }
            $split_key = \explode("\0", (string)$key, 3);
            if (3 === \count($split_key) && '' === $split_key[0]) {
                $child->name = $split_key[2];
                if ('*' === $split_key[1]) {
                    $child->access = Value::ACCESS_PROTECTED;
                } else {
                    $child->access = Value::ACCESS_PRIVATE;
                    $child->owner_class = $split_key[1];
                }
            } elseif (KINT_PHP72) {
                $child->name = (string)$key;
            } else {
                $child->name = $key;
            }
            if ($this->childHasPath($object, $child)) {
                $child->access_path = $object->access_path;
                if (!KINT_PHP72 && \is_int($child->name)) {
                    $child->access_path = 'array_values((array) ' . $child->access_path . ')[' . $i . ']';
                } elseif (\preg_match('/^[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*$/', $child->name)) {
                    $child->access_path .= '->' . $child->name;
                } else {
                    $child->access_path .= '->{' . \var_export((string)$child->name, true) . '}';
                }
            }
            $stash = $val;
            try {
                $copy[$i] = $refmarker;
            } catch (TypeError $e) {
                $child->reference = true;
            }
            if ($val === $refmarker) {
                $child->reference = true;
                $val = $stash;
            }
            $rep->contents[] = $this->parse($val, $child);
            ++$i;
        }
        $object->addRepresentation($rep);
        $object->value = $rep;
        $this->applyPlugins($var, $object, self::TRIGGER_SUCCESS);
        unset($this->object_hashes[$hash]);
        return $object;
    }

    public function childHasPath(InstanceValue $parent, Value $child): bool
    {
        if ('__PHP_Incomplete_Class' === $parent->classname) {
            return false;
        }
        if ('object' === $parent->type && (null !== $parent->access_path || $child->static || $child->const)) {
            if (Value::ACCESS_PUBLIC === $child->access) {
                return true;
            }
            if (Value::ACCESS_PRIVATE === $child->access && $this->caller_class) {
                if ($this->caller_class === $child->owner_class) {
                    return true;
                }
            } elseif (Value::ACCESS_PROTECTED === $child->access && $this->caller_class) {
                if ($this->caller_class === $child->owner_class) {
                    return true;
                }
                if (\is_subclass_of($this->caller_class, $child->owner_class)) {
                    return true;
                }
                if (\is_subclass_of($child->owner_class, $this->caller_class)) {
                    return true;
                }
            }
        }
        return false;
    }

    private function parseResource(&$var, Value $o): Value
    {
        $resource = new ResourceValue();
        $resource->transplant($o);
        $resource->resource_type = \get_resource_type($var);
        $this->applyPlugins($var, $resource, self::TRIGGER_SUCCESS);
        return $resource;
    }

    private function parseString(string &$var, Value $o): Value
    {
        $string = new BlobValue();
        $string->transplant($o);
        $string->encoding = BlobValue::detectEncoding($var);
        $string->size = \strlen($var);
        $rep = new Representation('Contents');
        $rep->contents = $var;
        $rep->implicit_label = true;
        $string->addRepresentation($rep);
        $string->value = $rep;
        $this->applyPlugins($var, $string, self::TRIGGER_SUCCESS);
        return $string;
    }

    private function parseResourceClosed(&$var, Value $o): Value
    {
        $o->type = 'resource (closed)';
        $this->applyPlugins($var, $o, self::TRIGGER_SUCCESS);
        return $o;
    }

    public function addPlugin(PluginInterface $p): bool
    {
        if (!$types = $p->getTypes()) {
            return false;
        }
        if (!$triggers = $p->getTriggers()) {
            return false;
        }
        $p->setParser($this);
        foreach ($types as $type) {
            if (!isset($this->plugins[$type])) {
                $this->plugins[$type] = [self::TRIGGER_BEGIN => [], self::TRIGGER_SUCCESS => [], self::TRIGGER_RECURSION => [], self::TRIGGER_DEPTH_LIMIT => [],];
            }
            foreach ($this->plugins[$type] as $trigger => &$pool) {
                if ($triggers & $trigger) {
                    $pool[] = $p;
                }
            }
        }
        return true;
    }

    public function clearPlugins(): void
    {
        $this->plugins = [];
    }

    public function haltParse(): void
    {
        $this->parse_break = true;
    }

    public function getCleanArray(array $array): array
    {
        unset($array[$this->marker]);
        return $array;
    }
}