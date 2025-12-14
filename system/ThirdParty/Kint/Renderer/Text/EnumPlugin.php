<?php
declare(strict_types=1);

namespace Kint\Renderer\Text;

use Kint\Zval\Value;

class EnumPlugin extends AbstractPlugin
{
    public function render(Value $o): string
    {
        return $this->renderLockedHeader($o);
    }
}