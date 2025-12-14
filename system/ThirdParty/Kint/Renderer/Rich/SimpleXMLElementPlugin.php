<?php
declare(strict_types=1);

namespace Kint\Renderer\Rich;

use Kint\Zval\BlobValue;
use Kint\Zval\SimpleXMLElementValue;
use Kint\Zval\Value;

class SimpleXMLElementPlugin extends AbstractPlugin implements ValuePluginInterface
{
    public function renderValue(Value $o): ?string
    {
        if (!($o instanceof SimpleXMLElementValue)) {
            return null;
        }
        if (!$o->isStringValue() || !empty($o->getRepresentation('attributes')->contents)) {
            return null;
        }
        $b = new BlobValue();
        $b->transplant($o);
        $b->type = 'string';
        $children = $this->renderer->renderChildren($b);
        $header = $this->renderer->renderHeader($o);
        $header = $this->renderer->renderHeaderWrapper($o, (bool)\strlen($children), $header);
        return '<dl>' . $header . $children . '</dl>';
    }
}