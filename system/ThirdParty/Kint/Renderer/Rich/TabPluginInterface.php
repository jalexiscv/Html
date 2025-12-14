<?php
declare(strict_types=1);

namespace Kint\Renderer\Rich;

use Kint\Zval\Representation\Representation;

interface TabPluginInterface extends PluginInterface
{
    public function renderTab(Representation $r): ?string;
}