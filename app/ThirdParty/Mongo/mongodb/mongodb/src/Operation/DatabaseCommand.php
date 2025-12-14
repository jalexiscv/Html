<?php

namespace MongoDB\Operation;

use MongoDB\Driver\Command;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\ReadPreference;
use MongoDB\Driver\Server;
use MongoDB\Driver\Session;
use MongoDB\Exception\InvalidArgumentException;
use function is_array;
use function is_object;

class DatabaseCommand implements Executable
{
    private $databaseName;
    private $command;
    private $options;

    public function __construct(string $databaseName, $command, array $options = [])
    {
        if (!is_array($command) && !is_object($command)) {
            throw InvalidArgumentException::invalidType('$command', $command, 'array or object');
        }
        if (isset($options['readPreference']) && !$options['readPreference'] instanceof ReadPreference) {
            throw InvalidArgumentException::invalidType('"readPreference" option', $options['readPreference'], ReadPreference::class);
        }
        if (isset($options['session']) && !$options['session'] instanceof Session) {
            throw InvalidArgumentException::invalidType('"session" option', $options['session'], Session::class);
        }
        if (isset($options['typeMap']) && !is_array($options['typeMap'])) {
            throw InvalidArgumentException::invalidType('"typeMap" option', $options['typeMap'], 'array');
        }
        $this->databaseName = $databaseName;
        $this->command = $command instanceof Command ? $command : new Command($command);
        $this->options = $options;
    }

    public function execute(Server $server)
    {
        $cursor = $server->executeCommand($this->databaseName, $this->command, $this->createOptions());
        if (isset($this->options['typeMap'])) {
            $cursor->setTypeMap($this->options['typeMap']);
        }
        return $cursor;
    }

    private function createOptions(): array
    {
        $options = [];
        if (isset($this->options['readPreference'])) {
            $options['readPreference'] = $this->options['readPreference'];
        }
        if (isset($this->options['session'])) {
            $options['session'] = $this->options['session'];
        }
        return $options;
    }
}