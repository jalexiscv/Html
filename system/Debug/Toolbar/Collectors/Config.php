<?php

namespace Higgs\Debug\Toolbar\Collectors;

use Higgs\Higgs;
use Config\Services;

class Config
{
    public static function display(): array
    {
        $config = config('App');
        return ['ciVersion' => Higgs::CI_VERSION, 'phpVersion' => PHP_VERSION, 'phpSAPI' => PHP_SAPI, 'environment' => ENVIRONMENT, 'baseURL' => $config->baseURL, 'timezone' => app_timezone(), 'locale' => Services::request()->getLocale(), 'cspEnabled' => $config->CSPEnabled,];
    }
}