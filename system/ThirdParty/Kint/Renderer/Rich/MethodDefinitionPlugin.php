<?php
declare(strict_types=1);

namespace Kint\Renderer\Rich;

use Kint\Kint;
use Kint\Zval\Representation\MethodDefinitionRepresentation;
use Kint\Zval\Representation\Representation;

class MethodDefinitionPlugin extends AbstractPlugin implements TabPluginInterface
{
    public function renderTab(Representation $r): ?string
    {
        if (!$r instanceof MethodDefinitionRepresentation) {
            return null;
        }
        if (isset($r->contents)) {
            $docstring = [];
            foreach (\explode("\n", $r->contents) as $line) {
                $docstring[] = \trim($line);
            }
            $docstring = $this->renderer->escape(\implode("\n", $docstring));
        }
        $addendum = [];
        if (isset($r->class) && $r->inherited) {
            $addendum[] = 'Inherited from ' . $this->renderer->escape($r->class);
        }
        if (isset($r->file, $r->line)) {
            $addendum[] = 'Defined in ' . $this->renderer->escape(Kint::shortenPath($r->file)) . ':' . ((int)$r->line);
        }
        if ($addendum) {
            $addendum = '<small>' . \implode("\n", $addendum) . '</small>';
            if (isset($docstring)) {
                $docstring .= "\n\n" . $addendum;
            } else {
                $docstring = $addendum;
            }
        }
        if (!isset($docstring)) {
            return null;
        }
        return '<pre>' . $docstring . '</pre>';
    }
}