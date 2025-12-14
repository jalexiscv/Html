<?php
declare(strict_types=1);

namespace Kint\Renderer\Rich;

use Kint\Zval\Value;

interface ValuePluginInterface extends PluginInterface
{
    public function renderValue(Value $o): ?string;
}