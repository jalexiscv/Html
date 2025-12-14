<?php
declare(strict_types=1);

namespace Kint\Parser;

use InvalidArgumentException;
use Kint\Zval\Value;

class ProxyPlugin implements PluginInterface
{
    protected $parser;
    protected $types;
    protected $triggers;
    protected $callback;

    public function __construct(array $types, int $triggers, $callback)
    {
        if (!\is_callable($callback)) {
            throw new InvalidArgumentException('ProxyPlugin callback must be callable');
        }
        $this->types = $types;
        $this->triggers = $triggers;
        $this->callback = $callback;
    }

    public function setParser(Parser $p): void
    {
        $this->parser = $p;
    }

    public function getTypes(): array
    {
        return $this->types;
    }

    public function getTriggers(): int
    {
        return $this->triggers;
    }

    public function parse(&$var, Value &$o, int $trigger): void
    {
        \call_user_func_array($this->callback, [&$var, &$o, $trigger, $this->parser]);
    }
}