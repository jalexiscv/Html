<?php

namespace Higgs\Exceptions;
class ConfigException extends CriticalError implements HasExitCodeInterface
{
    use DebugTraceableTrait;

    public static function forDisabledMigrations()
    {
        return new static(lang('Migrations.disabled'));
    }

    public function getExitCode(): int
    {
        return EXIT_CONFIG;
    }
}