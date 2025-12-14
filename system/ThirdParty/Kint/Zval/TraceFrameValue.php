<?php
declare(strict_types=1);

namespace Kint\Zval;

use InvalidArgumentException;
use Kint\Zval\Representation\Representation;
use Kint\Zval\Representation\SourceRepresentation;
use ReflectionFunction;
use ReflectionMethod;

class TraceFrameValue extends Value
{
    public $trace;
    public $hints = ['trace_frame'];

    public function __construct(Value $base, array $raw_frame)
    {
        parent::__construct();
        $this->transplant($base);
        if (!isset($this->value)) {
            throw new InvalidArgumentException('Tried to create TraceFrameValue from Value with no value representation');
        }
        $this->trace = ['function' => $raw_frame['function'], 'line' => $raw_frame['line'] ?? null, 'file' => $raw_frame['file'] ?? null, 'class' => $raw_frame['class'] ?? null, 'type' => $raw_frame['type'] ?? null, 'object' => null, 'args' => null,];
        if ($this->trace['class'] && \method_exists($this->trace['class'], $this->trace['function'])) {
            $func = new ReflectionMethod($this->trace['class'], $this->trace['function']);
            $this->trace['function'] = new MethodValue($func);
        } elseif (!$this->trace['class'] && \function_exists($this->trace['function'])) {
            $func = new ReflectionFunction($this->trace['function']);
            $this->trace['function'] = new MethodValue($func);
        }
        foreach ($this->value->contents as $frame_prop) {
            if ('object' === $frame_prop->name) {
                $this->trace['object'] = $frame_prop;
                $this->trace['object']->name = null;
                $this->trace['object']->operator = Value::OPERATOR_NONE;
            }
            if ('args' === $frame_prop->name) {
                $this->trace['args'] = $frame_prop->value->contents;
                if ($this->trace['function'] instanceof MethodValue) {
                    foreach (\array_values($this->trace['function']->parameters) as $param) {
                        if (isset($this->trace['args'][$param->position])) {
                            $this->trace['args'][$param->position]->name = $param->getName();
                        }
                    }
                }
            }
        }
        $this->clearRepresentations();
        if (isset($this->trace['file'], $this->trace['line']) && \is_readable($this->trace['file'])) {
            $this->addRepresentation(new SourceRepresentation($this->trace['file'], $this->trace['line']));
        }
        if ($this->trace['args']) {
            $args = new Representation('Arguments');
            $args->contents = $this->trace['args'];
            $this->addRepresentation($args);
        }
        if ($this->trace['object']) {
            $callee = new Representation('object');
            $callee->label = 'Callee object [' . $this->trace['object']->classname . ']';
            $callee->contents[] = $this->trace['object'];
            $this->addRepresentation($callee);
        }
    }
}