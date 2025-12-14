<?php
declare(strict_types=1);

namespace Kint\Renderer\Rich;

use Kint\Zval\Representation\ColorRepresentation;
use Kint\Zval\Representation\Representation;
use Kint\Zval\Value;

class ColorPlugin extends AbstractPlugin implements TabPluginInterface, ValuePluginInterface
{
    public function renderValue(Value $o): ?string
    {
        $r = $o->getRepresentation('color');
        if (!$r instanceof ColorRepresentation) {
            return null;
        }
        $children = $this->renderer->renderChildren($o);
        $header = $this->renderer->renderHeader($o);
        $header .= '<div class="kint-color-preview"><div style="background:';
        $header .= $r->getColor(ColorRepresentation::COLOR_RGBA);
        $header .= '"></div></div>';
        $header = $this->renderer->renderHeaderWrapper($o, (bool)\strlen($children), $header);
        return '<dl>' . $header . $children . '</dl>';
    }

    public function renderTab(Representation $r): ?string
    {
        if (!$r instanceof ColorRepresentation) {
            return null;
        }
        $out = '';
        if ($color = $r->getColor(ColorRepresentation::COLOR_NAME)) {
            $out .= '<dfn>' . $color . "</dfn>\n";
        }
        if ($color = $r->getColor(ColorRepresentation::COLOR_HEX_3)) {
            $out .= '<dfn>' . $color . "</dfn>\n";
        }
        if ($color = $r->getColor(ColorRepresentation::COLOR_HEX_6)) {
            $out .= '<dfn>' . $color . "</dfn>\n";
        }
        if ($r->hasAlpha()) {
            if ($color = $r->getColor(ColorRepresentation::COLOR_HEX_4)) {
                $out .= '<dfn>' . $color . "</dfn>\n";
            }
            if ($color = $r->getColor(ColorRepresentation::COLOR_HEX_8)) {
                $out .= '<dfn>' . $color . "</dfn>\n";
            }
            if ($color = $r->getColor(ColorRepresentation::COLOR_RGBA)) {
                $out .= '<dfn>' . $color . "</dfn>\n";
            }
            if ($color = $r->getColor(ColorRepresentation::COLOR_HSLA)) {
                $out .= '<dfn>' . $color . "</dfn>\n";
            }
        } else {
            if ($color = $r->getColor(ColorRepresentation::COLOR_RGB)) {
                $out .= '<dfn>' . $color . "</dfn>\n";
            }
            if ($color = $r->getColor(ColorRepresentation::COLOR_HSL)) {
                $out .= '<dfn>' . $color . "</dfn>\n";
            }
        }
        if (!\strlen($out)) {
            return null;
        }
        return '<pre>' . $out . '</pre>';
    }
}