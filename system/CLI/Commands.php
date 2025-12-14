<?php

namespace Higgs\CLI;

use Higgs\Autoloader\FileLocator;
use Higgs\Log\Logger;
use ReflectionClass;
use ReflectionException;

class Commands
{
    protected $commands = [];
    protected $logger;

    public function __construct($logger = null)
    {
        $this->logger = $logger ?? service('logger');
        $this->discoverCommands();
    }

    public function discoverCommands()
    {
        if ($this->commands !== []) {
            return;
        }
        $locator = service('locator');
        $files = $locator->listFiles('Commands/');
        if ($files === []) {
            return;
        }
        foreach ($files as $file) {
            $className = $locator->getClassname($file);
            if ($className === '' || !class_exists($className)) {
                continue;
            }
            try {
                $class = new ReflectionClass($className);
                if (!$class->isInstantiable() || !$class->isSubclassOf(BaseCommand::class)) {
                    continue;
                }
                $class = new $className($this->logger, $this);
                if (isset($class->group)) {
                    $this->commands[$class->name] = ['class' => $className, 'file' => $file, 'group' => $class->group, 'description' => $class->description,];
                }
                unset($class);
            } catch (ReflectionException $e) {
                $this->logger->error($e->getMessage());
            }
        }
        asort($this->commands);
    }

    public function run(string $command, array $params)
    {
        if (!$this->verifyCommand($command, $this->commands)) {
            return;
        }
        $className = $this->commands[$command]['class'];
        $class = new $className($this->logger, $this);
        return $class->run($params);
    }

    public function verifyCommand(string $command, array $commands): bool
    {
        if (isset($commands[$command])) {
            return true;
        }
        $message = lang('CLI.commandNotFound', [$command]);
        if ($alternatives = $this->getCommandAlternatives($command, $commands)) {
            if (count($alternatives) === 1) {
                $message .= "\n\n" . lang('CLI.altCommandSingular') . "\n    ";
            } else {
                $message .= "\n\n" . lang('CLI.altCommandPlural') . "\n    ";
            }
            $message .= implode("\n    ", $alternatives);
        }
        CLI::error($message);
        CLI::newLine();
        return false;
    }

    protected function getCommandAlternatives(string $name, array $collection): array
    {
        $alternatives = [];
        foreach (array_keys($collection) as $commandName) {
            $lev = levenshtein($name, $commandName);
            if ($lev <= strlen($commandName) / 3 || strpos($commandName, $name) !== false) {
                $alternatives[$commandName] = $lev;
            }
        }
        ksort($alternatives, SORT_NATURAL | SORT_FLAG_CASE);
        return array_keys($alternatives);
    }

    public function getCommands()
    {
        return $this->commands;
    }
}