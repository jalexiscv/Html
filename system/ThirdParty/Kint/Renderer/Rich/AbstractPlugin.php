<?php
declare(strict_types=1);

namespace Kint\Renderer\Rich;

use Kint\Renderer\RichRenderer;
use Kint\Zval\InstanceValue;
use Kint\Zval\Value;

abstract class AbstractPlugin implements PluginInterface
{
    protected $renderer;

    public function __construct(RichRenderer $r)
    {
        $this->renderer = $r;
    }

    public function renderLockedHeader(Value $o, string $content): string
    {
        $header = '<dt class="kint-parent kint-locked">';
        if (RichRenderer::$access_paths && $o->depth > 0 && $ap = $o->getAccessPath()) {
            $header .= '<span class="kint-access-path-trigger" title="Show access path">&rlarr;</span>';
        }
        $header .= '<span class="kint-popup-trigger" title="Open in new window">&boxbox;</span><nav></nav>';
        if (null !== ($s = $o->getModifiers())) {
            $header .= '<var>' . $s . '</var> ';
        }
        if (null !== ($s = $o->getName())) {
            $header .= '<dfn>' . $this->renderer->escape($s) . '</dfn> ';
            if ($s = $o->getOperator()) {
                $header .= $this->renderer->escape($s, 'ASCII') . ' ';
            }
        }
        if (null !== ($s = $o->getType())) {
            if (RichRenderer::$escape_types) {
                $s = $this->renderer->escape($s);
            }
            if ($o->reference) {
                $s = '&amp;' . $s;
            }
            $header .= '<var>' . $s . '</var>';
            if ($o instanceof InstanceValue && isset($o->spl_object_id)) {
                $header .= '#' . ((int)$o->spl_object_id);
            }
            $header .= ' ';
        }
        if (null !== ($s = $o->getSize())) {
            if (RichRenderer::$escape_types) {
                $s = $this->renderer->escape($s);
            }
            $header .= '(' . $s . ') ';
        }
        $header .= $content;
        if (!empty($ap)) {
            $header .= '<div class="access-path">' . $this->renderer->escape($ap) . '</div>';
        }
        return $header . '</dt>';
    }
}