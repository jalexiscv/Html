<?php

namespace Higgs\Commands\Database;

use Higgs\CLI\BaseCommand;
use Higgs\CLI\CLI;
use Config\Services;
use Throwable;

class Migrate extends BaseCommand
{
    protected $group = 'Database';
    protected $name = 'migrate';
    protected $description = 'Locates and runs all new migrations against the database.';
    protected $usage = 'migrate [options]';
    protected $options = ['-n' => 'Set migration namespace', '-g' => 'Set database group', '--all' => 'Set for all namespaces, will ignore (-n) option',];

    public function run(array $params)
    {
        $runner = Services::migrations();
        $runner->clearCliMessages();
        CLI::write(lang('Migrations.latest'), 'yellow');
        $namespace = $params['n'] ?? CLI::getOption('n');
        $group = $params['g'] ?? CLI::getOption('g');
        try {
            if (array_key_exists('all', $params) || CLI::getOption('all')) {
                $runner->setNamespace(null);
            } elseif ($namespace) {
                $runner->setNamespace($namespace);
            }
            if (!$runner->latest($group)) {
                CLI::error(lang('Migrations.generalFault'), 'light_gray', 'red');
            }
            $messages = $runner->getCliMessages();
            foreach ($messages as $message) {
                CLI::write($message);
            }
            CLI::write(lang('Migrations.migrated'), 'green');
        } catch (Throwable $e) {
            $this->showError($e);
        }
    }
}