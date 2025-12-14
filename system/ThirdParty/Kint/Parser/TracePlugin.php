<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Utils;
use Kint\Zval\TraceFrameValue;
use Kint\Zval\TraceValue;
use Kint\Zval\Value;

class TracePlugin extends AbstractPlugin
{
    public static $blacklist = ['spl_autoload_call'];
    public static $path_blacklist = [];

    public function getTypes(): array
    {
        return ['array'];
    }

    public function getTriggers(): int
    {
        return Parser::TRIGGER_SUCCESS;
    }

    public function parse(&$var, Value &$o, int $trigger): void
    {
        if (!$o->value) {
            return;
        }
        $trace = $this->parser->getCleanArray($var);
        if (\count($trace) !== \count($o->value->contents) || !Utils::isTrace($trace)) {
            return;
        }
        $traceobj = new TraceValue();
        $traceobj->transplant($o);
        $rep = $traceobj->value;
        $old_trace = $rep->contents;
        Utils::normalizeAliases(self::$blacklist);
        $path_blacklist = self::normalizePaths(self::$path_blacklist);
        $rep->contents = [];
        foreach ($old_trace as $frame) {
            $index = $frame->name;
            if (!isset($trace[$index]['function'])) {
                continue;
            }
            if (Utils::traceFrameIsListed($trace[$index], self::$blacklist)) {
                continue;
            }
            if (isset($trace[$index]['file']) && ($realfile = \realpath($trace[$index]['file']))) {
                foreach ($path_blacklist as $path) {
                    if (0 === \strpos($realfile, $path)) {
                        continue 2;
                    }
                }
            }
            $rep->contents[$index] = new TraceFrameValue($frame, $trace[$index]);
        }
        \ksort($rep->contents);
        $rep->contents = \array_values($rep->contents);
        $traceobj->clearRepresentations();
        $traceobj->addRepresentation($rep);
        $traceobj->size = \count($rep->contents);
        $o = $traceobj;
    }

    protected static function normalizePaths(array $paths): array
    {
        $normalized = [];
        foreach ($paths as $path) {
            $realpath = \realpath($path);
            if (\is_dir($realpath)) {
                $realpath .= DIRECTORY_SEPARATOR;
            }
            $normalized[] = $realpath;
        }
        return $normalized;
    }
}