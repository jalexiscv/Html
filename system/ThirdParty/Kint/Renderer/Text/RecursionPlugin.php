<?php
declare(strict_types=1);

namespace Kint\Renderer\Text;

use Kint\Zval\Value;

class RecursionPlugin extends AbstractPlugin
{
    public function render(Value $o): string
    {
        return $this->renderLockedHeader($o, 'RECURSION');
    }
}