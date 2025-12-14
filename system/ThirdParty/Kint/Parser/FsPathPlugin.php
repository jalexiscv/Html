<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\Representation\SplFileInfoRepresentation;
use Kint\Zval\Value;
use SplFileInfo;

class FsPathPlugin extends AbstractPlugin
{
    public static $blacklist = ['/', '.'];

    public function getTypes(): array
    {
        return ['string'];
    }

    public function getTriggers(): int
    {
        return Parser::TRIGGER_SUCCESS;
    }

    public function parse(&$var, Value &$o, int $trigger): void
    {
        if (\strlen($var) > 2048) {
            return;
        }
        if (!\preg_match('/[\\/\\' . DIRECTORY_SEPARATOR . ']/', $var)) {
            return;
        }
        if (\preg_match('/[?<>"*|]/', $var)) {
            return;
        }
        if (!@\file_exists($var)) {
            return;
        }
        if (\in_array($var, self::$blacklist, true)) {
            return;
        }
        $r = new SplFileInfoRepresentation(new SplFileInfo($var));
        $r->hints[] = 'fspath';
        $o->addRepresentation($r, 0);
    }
}