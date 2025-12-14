<?php
declare(strict_types=1);

namespace Kint\Renderer\Text;

use Kint\Renderer\TextRenderer;
use Kint\Zval\Value;

abstract class AbstractPlugin implements PluginInterface
{
    protected $renderer;

    public function __construct(TextRenderer $r)
    {
        $this->renderer = $r;
    }

    public function renderLockedHeader(Value $o, ?string $content = null): string
    {
        $out = '';
        if (0 == $o->depth) {
            $out .= $this->renderer->colorTitle($this->renderer->renderTitle($o)) . PHP_EOL;
        }
        $out .= $this->renderer->renderHeader($o);
        if (null !== $content) {
            $out .= ' ' . $this->renderer->colorValue($content);
        }
        $out .= PHP_EOL;
        return $out;
    }
}