<?php
declare(strict_types=1);

namespace Kint\Renderer\Rich;

use Kint\Zval\Value;

class RecursionPlugin extends AbstractPlugin implements ValuePluginInterface
{
    public function renderValue(Value $o): string
    {
        return '<dl>' . $this->renderLockedHeader($o, '<var>Recursion</var>') . '</dl>';
    }
}