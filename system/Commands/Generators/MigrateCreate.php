<?php

namespace Higgs\Commands\Generators;

use Higgs\CLI\BaseCommand;
use Higgs\CLI\CLI;

class MigrateCreate extends BaseCommand
{
    protected $group = 'Generators';
    protected $name = 'migrate:create';
    protected $description = '[DEPRECATED] Creates a new migration file. Please use "make:migration" instead.';
    protected $usage = 'migrate:create <name> [options]';
    protected $arguments = ['name' => 'The migration file name.',];
    protected $options = ['--namespace' => 'Set root namespace. Defaults to APP_NAMESPACE', '--force' => 'Force overwrite existing files.',];

    public function run(array $params)
    {
        $params[0] ??= CLI::getSegment(2);
        $params['namespace'] ??= CLI::getOption('namespace') ?? APP_NAMESPACE;
        if (array_key_exists('force', $params) || CLI::getOption('force')) {
            $params['force'] = null;
        }
        $this->call('make:migration', $params);
    }
}