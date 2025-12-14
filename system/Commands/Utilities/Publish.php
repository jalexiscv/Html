<?php

namespace Higgs\Commands\Utilities;

use Higgs\CLI\BaseCommand;
use Higgs\CLI\CLI;
use Higgs\Publisher\Publisher;

class Publish extends BaseCommand
{
    protected $group = 'Higgs';
    protected $name = 'publish';
    protected $description = 'Discovers and executes all predefined Publisher classes.';
    protected $usage = 'publish [<directory>]';
    protected $arguments = ['directory' => '[Optional] The directory to scan within each namespace. Default: "Publishers".',];
    protected $options = [];

    public function run(array $params)
    {
        $directory = array_shift($params) ?? 'Publishers';
        if ([] === $publishers = Publisher::discover($directory)) {
            CLI::write(lang('Publisher.publishMissing', [$directory]));
            return;
        }
        foreach ($publishers as $publisher) {
            if ($publisher->publish()) {
                CLI::write(lang('Publisher.publishSuccess', [get_class($publisher), count($publisher->getPublished()), $publisher->getDestination(),]), 'green');
            } else {
                CLI::error(lang('Publisher.publishFailure', [get_class($publisher), $publisher->getDestination(),]), 'light_gray', 'red');
                foreach ($publisher->getErrors() as $file => $exception) {
                    CLI::write($file);
                    CLI::error($exception->getMessage());
                    CLI::newLine();
                }
            }
        }
    }
}