<?php

namespace Higgs\Commands\Generators;

use Higgs\CLI\BaseCommand;
use Higgs\CLI\CLI;
use Higgs\CLI\GeneratorTrait;

class SessionMigrationGenerator extends BaseCommand
{
    use GeneratorTrait;

    protected $group = 'Generators';
    protected $name = 'session:migration';
    protected $description = '[DEPRECATED] Generates the migration file for database sessions, Please use  "make:migration --session" instead.';
    protected $usage = 'session:migration [options]';
    protected $options = ['-t' => 'Supply a table name.', '-g' => 'Database group to use. Default: "default".',];

    public function run(array $params)
    {
        $this->component = 'Migration';
        $this->directory = 'Database\Migrations';
        $this->template = 'migration.tpl.php';
        $table = 'ci_sessions';
        if (array_key_exists('t', $params) || CLI::getOption('t')) {
            $table = $params['t'] ?? CLI::getOption('t');
        }
        $params[0] = "_create_{$table}_table";
        $this->execute($params);
    }

    protected function prepare(string $class): string
    {
        $data['session'] = true;
        $data['table'] = $this->getOption('t');
        $data['DBGroup'] = $this->getOption('g');
        $data['matchIP'] = config('App')->sessionMatchIP ?? false;
        $data['table'] = is_string($data['table']) ? $data['table'] : 'ci_sessions';
        $data['DBGroup'] = is_string($data['DBGroup']) ? $data['DBGroup'] : 'default';
        return $this->parseTemplate($class, [], [], $data);
    }

    protected function basename(string $filename): string
    {
        return gmdate(config('Migrations')->timestampFormat) . basename($filename);
    }
}