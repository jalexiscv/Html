<?php
declare(strict_types=1);

namespace Kint\Renderer\Rich;

use Kint\Zval\Value;

class DepthLimitPlugin extends AbstractPlugin implements ValuePluginInterface
{
    public function renderValue(Value $o): string
    {
        return '<dl>' . $this->renderLockedHeader($o, '<var>Depth Limit</var>') . '</dl>';
    }
}