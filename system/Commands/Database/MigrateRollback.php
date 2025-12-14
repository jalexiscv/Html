<?php

namespace Higgs\Commands\Database;

use Higgs\CLI\BaseCommand;
use Higgs\CLI\CLI;
use Config\Services;
use Throwable;

class MigrateRollback extends BaseCommand
{
    protected $group = 'Database';
    protected $name = 'migrate:rollback';
    protected $description = 'Runs the "down" method for all migrations in the last batch.';
    protected $usage = 'migrate:rollback [options]';
    protected $options = ['-b' => 'Specify a batch to roll back to; e.g. "3" to return to batch #3 or "-2" to roll back twice', '-g' => 'Set database group', '-f' => 'Force command - this option allows you to bypass the confirmation question when running this command in a production environment',];

    public function run(array $params)
    {
        if (ENVIRONMENT === 'production') {
            $force = array_key_exists('f', $params) || CLI::getOption('f');
            if (!$force && CLI::prompt(lang('Migrations.rollBackConfirm'), ['y', 'n']) === 'n') {
                return;
            }
        }
        $runner = Services::migrations();
        $group = $params['g'] ?? CLI::getOption('g');
        if (is_string($group)) {
            $runner->setGroup($group);
        }
        try {
            $batch = $params['b'] ?? CLI::getOption('b') ?? $runner->getLastBatch() - 1;
            CLI::write(lang('Migrations.rollingBack') . ' ' . $batch, 'yellow');
            if (!$runner->regress($batch)) {
                CLI::error(lang('Migrations.generalFault'), 'light_gray', 'red');
            }
            $messages = $runner->getCliMessages();
            foreach ($messages as $message) {
                CLI::write($message);
            }
            CLI::write('Done rolling back migrations.', 'green');
        } catch (Throwable $e) {
            $this->showError($e);
        }
    }
}