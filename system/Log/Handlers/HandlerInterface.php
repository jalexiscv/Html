<?php

namespace Higgs\Log\Handlers;
interface HandlerInterface
{
    public function handle($level, $message): bool;

    public function canHandle(string $level): bool;

    public function setDateFormat(string $format);
}