<?php

namespace Higgs\CLI;

use Higgs\Higgs;
use Config\Services;
use Exception;

class Console
{
    public function run()
    {
        $runner = Services::commands();
        $params = array_merge(CLI::getSegments(), CLI::getOptions());
        $params = $this->parseParamsForHelpOption($params);
        $command = array_shift($params) ?? 'list';
        return $runner->run($command, $params);
    }

    private function parseParamsForHelpOption(array $params): array
    {
        if (array_key_exists('help', $params)) {
            unset($params['help']);
            $params = $params === [] ? ['list'] : $params;
            array_unshift($params, 'help');
        }
        return $params;
    }

    public function showHeader(bool $suppress = false)
    {
        if ($suppress) {
            return;
        }
        CLI::write(sprintf('Higgs v%s Command Line Tool - Server Time: %s UTC%s', Higgs::CI_VERSION, date('Y-m-d H:i:s'), date('P')), 'green');
        CLI::newLine();
    }
}