<?php
declare(strict_types=1);

namespace Kint\Renderer\Rich;

use Kint\Zval\Representation\Representation;

class BinaryPlugin extends AbstractPlugin implements TabPluginInterface
{
    public static $line_length = 0x10;
    public static $chunk_length = 0x4;

    public function renderTab(Representation $r): ?string
    {
        if (!\is_string($r->contents)) {
            return null;
        }
        $out = '<pre>';
        $lines = \str_split($r->contents, self::$line_length);
        foreach ($lines as $index => $line) {
            $out .= \sprintf('%08X', $index * self::$line_length) . ":\t";
            $chunks = \str_split(\str_pad(\bin2hex($line), 2 * self::$line_length, ' '), self::$chunk_length);
            $out .= \implode(' ', $chunks);
            $out .= "\t" . \preg_replace('/[^\\x20-\\x7E]/', '.', $line) . "\n";
        }
        $out .= '</pre>';
        return $out;
    }
}