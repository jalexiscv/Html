<?php
declare(strict_types=1);

namespace Kint\Renderer\Rich;

use Kint\Kint;
use Kint\Zval\ClosureValue;
use Kint\Zval\Value;

class ClosurePlugin extends AbstractPlugin implements ValuePluginInterface
{
    public function renderValue(Value $o): ?string
    {
        if (!$o instanceof ClosureValue) {
            return null;
        }
        $children = $this->renderer->renderChildren($o);
        $header = '';
        if (null !== ($s = $o->getModifiers())) {
            $header .= '<var>' . $s . '</var> ';
        }
        if (null !== ($s = $o->getName())) {
            $header .= '<dfn>' . $this->renderer->escape($s) . '(' . $this->renderer->escape($o->getParams()) . ')</dfn> ';
        }
        $header .= '<var>Closure</var>';
        if (isset($o->spl_object_id)) {
            $header .= '#' . ((int)$o->spl_object_id);
        }
        $header .= ' ' . $this->renderer->escape(Kint::shortenPath($o->filename)) . ':' . (int)$o->startline;
        $header = $this->renderer->renderHeaderWrapper($o, (bool)\strlen($children), $header);
        return '<dl>' . $header . $children . '</dl>';
    }
}