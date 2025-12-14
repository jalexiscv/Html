<?php

namespace Higgs\Commands\Generators;

use Higgs\CLI\BaseCommand;
use Higgs\CLI\CLI;
use Higgs\CLI\GeneratorTrait;
use Config\App as AppConfig;
use Config\Session as SessionConfig;

class MigrationGenerator extends BaseCommand
{
    use GeneratorTrait;

    protected $group = 'Generators';
    protected $name = 'make:migration';
    protected $description = 'Generates a new migration file.';
    protected $usage = 'make:migration <name> [options]';
    protected $arguments = ['name' => 'The migration class name.',];
    protected $options = ['--session' => 'Generates the migration file for database sessions.', '--table' => 'Table name to use for database sessions. Default: "ci_sessions".', '--dbgroup' => 'Database group to use for database sessions. Default: "default".', '--namespace' => 'Set root namespace. Default: "APP_NAMESPACE".', '--suffix' => 'Append the component title to the class name (e.g. User => UserMigration).',];

    public function run(array $params)
    {
        $this->component = 'Migration';
        $this->directory = 'Database\Migrations';
        $this->template = 'migration.tpl.php';
        if (array_key_exists('session', $params) || CLI::getOption('session')) {
            $table = $params['table'] ?? CLI::getOption('table') ?? 'ci_sessions';
            $params[0] = "_create_{$table}_table";
        }
        $this->classNameLang = 'CLI.generator.className.migration';
        $this->execute($params);
    }

    protected function prepare(string $class): string
    {
        $data['session'] = false;
        if ($this->getOption('session')) {
            $table = $this->getOption('table');
            $DBGroup = $this->getOption('dbgroup');
            $data['session'] = true;
            $data['table'] = is_string($table) ? $table : 'ci_sessions';
            $data['DBGroup'] = is_string($DBGroup) ? $DBGroup : 'default';
            $data['DBDriver'] = config('Database')->{$data['DBGroup']}['DBDriver'];
            $config = config('App');
            $session = config('Session');
            $data['matchIP'] = ($session instanceof SessionConfig) ? $session->matchIP : $config->sessionMatchIP;
        }
        return $this->parseTemplate($class, [], [], $data);
    }

    protected function basename(string $filename): string
    {
        return gmdate(config('Migrations')->timestampFormat) . basename($filename);
    }
}