<?php

namespace Higgs\Database;

use Higgs\CLI\CLI;
use Higgs\Events\Events;
use Higgs\Exceptions\ConfigException;
use Higgs\I18n\Time;
use Config\Database;
use Config\Migrations as MigrationsConfig;
use Config\Services;
use RuntimeException;
use stdClass;

class MigrationRunner
{
    protected $enabled = false;
    protected $table;
    protected $namespace;
    protected $group;
    protected $name;
    protected $regex = '/\A(\d{4}[_-]?\d{2}[_-]?\d{2}[_-]?\d{6})_(\w+)\z/';
    protected $db;
    protected $silent = false;
    protected $cliMessages = [];
    protected $tableChecked = false;
    protected $path;
    protected $groupFilter;
    protected $groupSkip = false;

    public function __construct(MigrationsConfig $config, $db = null)
    {
        $this->enabled = $config->enabled ?? false;
        $this->table = $config->table ?? 'migrations';
        $this->namespace = APP_NAMESPACE;
        $config = config('Database');
        $this->group = $config->defaultGroup;
        unset($config);
        $this->db = db_connect($db);
    }

    public function latest(?string $group = null)
    {
        if (!$this->enabled) {
            throw ConfigException::forDisabledMigrations();
        }
        $this->ensureTable();
        if ($group !== null) {
            $this->groupFilter = $group;
            $this->setGroup($group);
        }
        $migrations = $this->findMigrations();
        if (empty($migrations)) {
            return true;
        }
        foreach ($this->getHistory((string)$group) as $history) {
            unset($migrations[$this->getObjectUid($history)]);
        }
        $batch = $this->getLastBatch() + 1;
        foreach ($migrations as $migration) {
            if ($this->migrate('up', $migration)) {
                if ($this->groupSkip === true) {
                    $this->groupSkip = false;
                    continue;
                }
                $this->addHistory($migration, $batch);
            } else {
                $this->regress(-1);
                $message = lang('Migrations.generalFault');
                if ($this->silent) {
                    $this->cliMessages[] = "\t" . CLI::color($message, 'red');
                    return false;
                }
                throw new RuntimeException($message);
            }
        }
        $data = get_object_vars($this);
        $data['method'] = 'latest';
        Events::trigger('migrate', $data);
        return true;
    }

    public function ensureTable()
    {
        if ($this->tableChecked || $this->db->tableExists($this->table)) {
            return;
        }
        $forge = Database::forge($this->db);
        $forge->addField(['id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true,], 'version' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false,], 'class' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false,], 'group' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false,], 'namespace' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false,], 'time' => ['type' => 'INT', 'constraint' => 11, 'null' => false,], 'batch' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false,],]);
        $forge->addPrimaryKey('id');
        $forge->createTable($this->table, true);
        $this->tableChecked = true;
    }

    public function setGroup(string $group)
    {
        $this->group = $group;
        return $this;
    }

    public function findMigrations(): array
    {
        $namespaces = $this->namespace ? [$this->namespace] : array_keys(Services::autoloader()->getNamespace());
        $migrations = [];
        foreach ($namespaces as $namespace) {
            if (ENVIRONMENT !== 'testing' && $namespace === 'Tests\Support') {
                continue;
            }
            foreach ($this->findNamespaceMigrations($namespace) as $migration) {
                $migrations[$migration->uid] = $migration;
            }
        }
        ksort($migrations);
        return $migrations;
    }

    public function findNamespaceMigrations(string $namespace): array
    {
        $migrations = [];
        $locator = Services::locator(true);
        if (!empty($this->path)) {
            helper('filesystem');
            $dir = rtrim($this->path, DIRECTORY_SEPARATOR) . '/';
            $files = get_filenames($dir, true, false, false);
        } else {
            $files = $locator->listNamespaceFiles($namespace, '/Database/Migrations/');
        }
        foreach ($files as $file) {
            $file = empty($this->path) ? $file : $this->path . str_replace($this->path, '', $file);
            if ($migration = $this->migrationFromFile($file, $namespace)) {
                $migrations[] = $migration;
            }
        }
        return $migrations;
    }

    protected function migrationFromFile(string $path, string $namespace)
    {
        if (substr($path, -4) !== '.php') {
            return false;
        }
        $filename = basename($path, '.php');
        if (!preg_match($this->regex, $filename)) {
            return false;
        }
        $locator = Services::locator(true);
        $migration = new stdClass();
        $migration->version = $this->getMigrationNumber($filename);
        $migration->name = $this->getMigrationName($filename);
        $migration->path = $path;
        $migration->class = $locator->getClassname($path);
        $migration->namespace = $namespace;
        $migration->uid = $this->getObjectUid($migration);
        return $migration;
    }

    protected function getMigrationNumber(string $migration): string
    {
        preg_match($this->regex, $migration, $matches);
        return count($matches) ? $matches[1] : '0';
    }

    protected function getMigrationName(string $migration): string
    {
        preg_match($this->regex, $migration, $matches);
        return count($matches) ? $matches[2] : '';
    }

    public function getObjectUid($object): string
    {
        return preg_replace('/[^0-9]/', '', $object->version) . $object->class;
    }

    public function getHistory(string $group = 'default'): array
    {
        $this->ensureTable();
        $builder = $this->db->table($this->table);
        if (!empty($group)) {
            $builder->where('group', $group);
        }
        if ($this->namespace) {
            $builder->where('namespace', $this->namespace);
        }
        $query = $builder->orderBy('id', 'ASC')->get();
        return !empty($query) ? $query->getResultObject() : [];
    }

    public function getLastBatch(): int
    {
        $this->ensureTable();
        $batch = $this->db->table($this->table)->selectMax('batch')->get()->getResultObject();
        $batch = is_array($batch) && count($batch) ? end($batch)->batch : 0;
        return (int)$batch;
    }

    protected function migrate($direction, $migration): bool
    {
        include_once $migration->path;
        $class = $migration->class;
        $this->setName($migration->name);
        if (!class_exists($class, false)) {
            $message = sprintf(lang('Migrations.classNotFound'), $class);
            if ($this->silent) {
                $this->cliMessages[] = "\t" . CLI::color($message, 'red');
                return false;
            }
            throw new RuntimeException($message);
        }
        $instance = new $class();
        $group = $instance->getDBGroup() ?? config('Database')->defaultGroup;
        if (ENVIRONMENT !== 'testing' && $group === 'tests' && $this->groupFilter !== 'tests') {
            $this->groupSkip = true;
            return true;
        }
        if ($direction === 'up' && $this->groupFilter !== null && $this->groupFilter !== $group) {
            $this->groupSkip = true;
            return true;
        }
        $this->setGroup($group);
        if (!is_callable([$instance, $direction])) {
            $message = sprintf(lang('Migrations.missingMethod'), $direction);
            if ($this->silent) {
                $this->cliMessages[] = "\t" . CLI::color($message, 'red');
                return false;
            }
            throw new RuntimeException($message);
        }
        $instance->{$direction}();
        return true;
    }

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    protected function addHistory($migration, int $batch)
    {
        $this->db->table($this->table)->insert(['version' => $migration->version, 'class' => $migration->class, 'group' => $this->group, 'namespace' => $migration->namespace, 'time' => Time::now()->getTimestamp(), 'batch' => $batch,]);
        if (is_cli()) {
            $this->cliMessages[] = sprintf("\t%s(%s) %s_%s", CLI::color(lang('Migrations.added'), 'yellow'), $migration->namespace, $migration->version, $migration->class);
        }
    }

    public function regress(int $targetBatch = 0, ?string $group = null)
    {
        if (!$this->enabled) {
            throw ConfigException::forDisabledMigrations();
        }
        if ($group !== null) {
            $this->setGroup($group);
        }
        $this->ensureTable();
        $batches = $this->getBatches();
        if ($targetBatch < 0) {
            $targetBatch = $batches[count($batches) - 1 + $targetBatch] ?? 0;
        }
        if (empty($batches) && $targetBatch === 0) {
            return true;
        }
        if ($targetBatch !== 0 && !in_array($targetBatch, $batches, true)) {
            $message = lang('Migrations.batchNotFound') . $targetBatch;
            if ($this->silent) {
                $this->cliMessages[] = "\t" . CLI::color($message, 'red');
                return false;
            }
            throw new RuntimeException($message);
        }
        $tmpNamespace = $this->namespace;
        $this->namespace = null;
        $allMigrations = $this->findMigrations();
        $migrations = [];
        while ($batch = array_pop($batches)) {
            if ($batch <= $targetBatch) {
                break;
            }
            foreach ($this->getBatchHistory($batch, 'desc') as $history) {
                $uid = $this->getObjectUid($history);
                if (!isset($allMigrations[$uid])) {
                    $message = lang('Migrations.gap') . ' ' . $history->version;
                    if ($this->silent) {
                        $this->cliMessages[] = "\t" . CLI::color($message, 'red');
                        return false;
                    }
                    throw new RuntimeException($message);
                }
                $migration = $allMigrations[$uid];
                $migration->history = $history;
                $migrations[] = $migration;
            }
        }
        foreach ($migrations as $migration) {
            if ($this->migrate('down', $migration)) {
                $this->removeHistory($migration->history);
            } else {
                $message = lang('Migrations.generalFault');
                if ($this->silent) {
                    $this->cliMessages[] = "\t" . CLI::color($message, 'red');
                    return false;
                }
                throw new RuntimeException($message);
            }
        }
        $data = get_object_vars($this);
        $data['method'] = 'regress';
        Events::trigger('migrate', $data);
        $this->namespace = $tmpNamespace;
        return true;
    }

    public function getBatches(): array
    {
        $this->ensureTable();
        $batches = $this->db->table($this->table)->select('batch')->distinct()->orderBy('batch', 'asc')->get()->getResultArray();
        return array_map('intval', array_column($batches, 'batch'));
    }

    public function getBatchHistory(int $batch, $order = 'asc'): array
    {
        $this->ensureTable();
        $query = $this->db->table($this->table)->where('batch', $batch)->orderBy('id', $order)->get();
        return !empty($query) ? $query->getResultObject() : [];
    }

    protected function removeHistory($history)
    {
        $this->db->table($this->table)->where('id', $history->id)->delete();
        if (is_cli()) {
            $this->cliMessages[] = sprintf("\t%s(%s) %s_%s", CLI::color(lang('Migrations.removed'), 'yellow'), $history->namespace, $history->version, $history->class);
        }
    }

    public function force(string $path, string $namespace, ?string $group = null)
    {
        if (!$this->enabled) {
            throw ConfigException::forDisabledMigrations();
        }
        $this->ensureTable();
        if ($group !== null) {
            $this->groupFilter = $group;
            $this->setGroup($group);
        }
        $migration = $this->migrationFromFile($path, $namespace);
        if (empty($migration)) {
            $message = lang('Migrations.notFound');
            if ($this->silent) {
                $this->cliMessages[] = "\t" . CLI::color($message, 'red');
                return false;
            }
            throw new RuntimeException($message);
        }
        $method = 'up';
        $this->setNamespace($migration->namespace);
        foreach ($this->getHistory($this->group) as $history) {
            if ($this->getObjectUid($history) === $migration->uid) {
                $method = 'down';
                $migration->history = $history;
                break;
            }
        }
        if ($method === 'up') {
            $batch = $this->getLastBatch() + 1;
            if ($this->migrate('up', $migration) && $this->groupSkip === false) {
                $this->addHistory($migration, $batch);
                return true;
            }
            $this->groupSkip = false;
        } elseif ($this->migrate('down', $migration)) {
            $this->removeHistory($migration->history);
            return true;
        }
        $message = lang('Migrations.generalFault');
        if ($this->silent) {
            $this->cliMessages[] = "\t" . CLI::color($message, 'red');
            return false;
        }
        throw new RuntimeException($message);
    }

    public function setNamespace(?string $namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    public function setSilent(bool $silent)
    {
        $this->silent = $silent;
        return $this;
    }

    public function getCliMessages(): array
    {
        return $this->cliMessages;
    }

    public function clearCliMessages()
    {
        $this->cliMessages = [];
        return $this;
    }

    public function clearHistory()
    {
        if ($this->db->tableExists($this->table)) {
            $this->db->table($this->table)->truncate();
        }
    }

    public function getBatchStart(int $batch): string
    {
        if ($batch < 0) {
            $batches = $this->getBatches();
            $batch = $batches[count($batches) - 1] ?? 0;
        }
        $migration = $this->db->table($this->table)->where('batch', $batch)->orderBy('id', 'asc')->limit(1)->get()->getResultObject();
        return count($migration) ? $migration[0]->version : '0';
    }

    public function getBatchEnd(int $batch): string
    {
        if ($batch < 0) {
            $batches = $this->getBatches();
            $batch = $batches[count($batches) - 1] ?? 0;
        }
        $migration = $this->db->table($this->table)->where('batch', $batch)->orderBy('id', 'desc')->limit(1)->get()->getResultObject();
        return count($migration) ? $migration[0]->version : 0;
    }
}