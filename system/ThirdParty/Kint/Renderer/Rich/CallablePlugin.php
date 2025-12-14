<?php
declare(strict_types=1);

namespace Kint\Renderer\Rich;

use Kint\Renderer\RichRenderer;
use Kint\Utils;
use Kint\Zval\ClosureValue;
use Kint\Zval\MethodValue;
use Kint\Zval\Value;

class CallablePlugin extends ClosurePlugin
{
    protected static $method_cache = [];
    protected $closure_plugin = null;

    public function renderValue(Value $o): ?string
    {
        if ($o instanceof MethodValue) {
            return $this->renderMethod($o);
        }
        if ($o instanceof ClosureValue) {
            return parent::renderValue($o);
        }
        return null;
    }

    protected function renderMethod(MethodValue $o): string
    {
        if (!empty(self::$method_cache[$o->owner_class][$o->name])) {
            $children = self::$method_cache[$o->owner_class][$o->name]['children'];
            $header = $this->renderer->renderHeaderWrapper($o, (bool)\strlen($children), self::$method_cache[$o->owner_class][$o->name]['header']);
            return '<dl>' . $header . $children . '</dl>';
        }
        $children = $this->renderer->renderChildren($o);
        $header = '';
        if (null !== ($s = $o->getModifiers()) || $o->return_reference) {
            $header .= '<var>' . $s;
            if ($o->return_reference) {
                if ($s) {
                    $header .= ' ';
                }
                $header .= $this->renderer->escape('&');
            }
            $header .= '</var> ';
        }
        if (null !== ($s = $o->getName())) {
            $function = $this->renderer->escape($s) . '(' . $this->renderer->escape($o->getParams()) . ')';
            if (null !== ($url = $o->getPhpDocUrl())) {
                $function = '<a href="' . $url . '" target=_blank>' . $function . '</a>';
            }
            $header .= '<dfn>' . $function . '</dfn>';
        }
        if (!empty($o->returntype)) {
            $header .= ': <var>';
            if ($o->return_reference) {
                $header .= $this->renderer->escape('&');
            }
            $header .= $this->renderer->escape($o->returntype) . '</var>';
        } elseif ($o->docstring) {
            if (\preg_match('/@return\\s+(.*)\\r?\\n/m', $o->docstring, $matches)) {
                if (\trim($matches[1])) {
                    $header .= ': <var>' . $this->renderer->escape(\trim($matches[1])) . '</var>';
                }
            }
        }
        if (null !== ($s = $o->getValueShort())) {
            if (RichRenderer::$strlen_max) {
                $s = Utils::truncateString($s, RichRenderer::$strlen_max);
            }
            $header .= ' ' . $this->renderer->escape($s);
        }
        if (\strlen($o->owner_class) && \strlen($o->name)) {
            self::$method_cache[$o->owner_class][$o->name] = ['header' => $header, 'children' => $children,];
        }
        $header = $this->renderer->renderHeaderWrapper($o, (bool)\strlen($children), $header);
        return '<dl>' . $header . $children . '</dl>';
    }
}