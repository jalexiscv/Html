<?php

namespace Higgs\Database;

use Higgs\CLI\CLI;
use Config\Database;
use Faker\Factory;
use Faker\Generator;
use InvalidArgumentException;

class Seeder
{
    private static ?Generator $faker = null;
    protected $DBGroup;
    protected $seedPath;
    protected $config;
    protected $db;
    protected $forge;
    protected $silent = false;

    public function __construct(Database $config, ?BaseConnection $db = null)
    {
        $this->seedPath = $config->filesPath ?? APPPATH . 'Database/';
        if (empty($this->seedPath)) {
            throw new InvalidArgumentException('Invalid filesPath set in the Config\Database.');
        }
        $this->seedPath = rtrim($this->seedPath, '\\/') . '/Seeds/';
        if (!is_dir($this->seedPath)) {
            throw new InvalidArgumentException('Unable to locate the seeds directory. Please check Config\Database::filesPath');
        }
        $this->config = &$config;
        $db ??= Database::connect($this->DBGroup);
        $this->db = $db;
        $this->forge = Database::forge($this->DBGroup);
    }

    public static function faker(): ?Generator
    {
        if (self::$faker === null && class_exists(Factory::class)) {
            self::$faker = Factory::create();
        }
        return self::$faker;
    }

    public function call(string $class)
    {
        $class = trim($class);
        if ($class === '') {
            throw new InvalidArgumentException('No seeder was specified.');
        }
        if (strpos($class, '\\') === false) {
            $path = $this->seedPath . str_replace('.php', '', $class) . '.php';
            if (!is_file($path)) {
                throw new InvalidArgumentException('The specified seeder is not a valid file: ' . $path);
            }
            $class = APP_NAMESPACE . '\Database\Seeds\\' . $class;
            if (!class_exists($class, false)) {
                require_once $path;
            }
        }
        $seeder = new $class($this->config);
        $seeder->setSilent($this->silent)->run();
        unset($seeder);
        if (is_cli() && !$this->silent) {
            CLI::write("Seeded: {$class}", 'green');
        }
    }

    public function run()
    {
    }

    public function setSilent(bool $silent)
    {
        $this->silent = $silent;
        return $this;
    }

    public function setPath(string $path)
    {
        $this->seedPath = rtrim($path, '\\/') . '/';
        return $this;
    }
}