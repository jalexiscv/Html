<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\Value;

interface PluginInterface
{
    public function setParser(Parser $p): void;

    public function getTypes(): array;

    public function getTriggers(): int;

    public function parse(&$var, Value &$o, int $trigger): void;
}