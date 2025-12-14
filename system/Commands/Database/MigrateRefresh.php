<?php

namespace Higgs\Commands\Database;

use Higgs\CLI\BaseCommand;
use Higgs\CLI\CLI;

class MigrateRefresh extends BaseCommand
{
    protected $group = 'Database';
    protected $name = 'migrate:refresh';
    protected $description = 'Does a rollback followed by a latest to refresh the current state of the database.';
    protected $usage = 'migrate:refresh [options]';
    protected $options = ['-n' => 'Set migration namespace', '-g' => 'Set database group', '--all' => 'Set latest for all namespace, will ignore (-n) option', '-f' => 'Force command - this option allows you to bypass the confirmation question when running this command in a production environment',];

    public function run(array $params)
    {
        $params['b'] = 0;
        if (ENVIRONMENT === 'production') {
            $force = array_key_exists('f', $params) || CLI::getOption('f');
            if (!$force && CLI::prompt(lang('Migrations.refreshConfirm'), ['y', 'n']) === 'n') {
                return;
            }
            $params['f'] = null;
        }
        $this->call('migrate:rollback', $params);
        $this->call('migrate', $params);
    }
}