<?php
declare(strict_types=1);

namespace Kint;

use Kint\Parser\Parser;
use Kint\Renderer\RendererInterface;
use Kint\Zval\Value;

interface FacadeInterface
{
    public function __construct(Parser $p, RendererInterface $r);

    public function setStatesFromStatics(array $statics): void;

    public function setStatesFromCallInfo(array $info): void;

    public function dumpAll(array $vars, array $base): string;
}