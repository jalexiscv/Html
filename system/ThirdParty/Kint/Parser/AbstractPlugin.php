<?php
declare(strict_types=1);

namespace Kint\Parser;
abstract class AbstractPlugin implements ConstructablePluginInterface
{
    protected $parser;

    public function __construct()
    {
    }

    public function setParser(Parser $p): void
    {
        $this->parser = $p;
    }
}