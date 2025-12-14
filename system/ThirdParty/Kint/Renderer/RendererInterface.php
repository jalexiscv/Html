<?php
declare(strict_types=1);

namespace Kint\Renderer;

use Kint\Zval\Value;

interface RendererInterface
{
    public function __construct();

    public function render(Value $o): string;

    public function renderNothing(): string;

    public function setCallInfo(array $info): void;

    public function getCallInfo(): array;

    public function setStatics(array $statics): void;

    public function getStatics(): array;

    public function setShowTrace(bool $show_trace): void;

    public function getShowTrace(): bool;

    public function filterParserPlugins(array $plugins): array;

    public function preRender(): string;

    public function postRender(): string;
}