<?php

namespace MongoDB\Operation;

use MongoDB\Driver\Command;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\ReadPreference;
use MongoDB\Driver\Server;
use MongoDB\Driver\Session;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnsupportedException;
use function current;
use function is_array;
use function is_string;
use function MongoDB\server_supports_feature;

class Explain implements Executable
{
    public const VERBOSITY_ALL_PLANS = 'allPlansExecution';
    public const VERBOSITY_EXEC_STATS = 'executionStats';
    public const VERBOSITY_QUERY = 'queryPlanner';
    private static $wireVersionForAggregate = 7;
    private $databaseName;
    private $explainable;
    private $options;

    public function __construct(string $databaseName, Explainable $explainable, array $options = [])
    {
        if (isset($options['readPreference']) && !$options['readPreference'] instanceof ReadPreference) {
            throw InvalidArgumentException::invalidType('"readPreference" option', $options['readPreference'], ReadPreference::class);
        }
        if (isset($options['session']) && !$options['session'] instanceof Session) {
            throw InvalidArgumentException::invalidType('"session" option', $options['session'], Session::class);
        }
        if (isset($options['typeMap']) && !is_array($options['typeMap'])) {
            throw InvalidArgumentException::invalidType('"typeMap" option', $options['typeMap'], 'array');
        }
        if (isset($options['verbosity']) && !is_string($options['verbosity'])) {
            throw InvalidArgumentException::invalidType('"verbosity" option', $options['verbosity'], 'string');
        }
        $this->databaseName = $databaseName;
        $this->explainable = $explainable;
        $this->options = $options;
    }

    public function execute(Server $server)
    {
        if ($this->explainable instanceof Aggregate && !server_supports_feature($server, self::$wireVersionForAggregate)) {
            throw UnsupportedException::explainNotSupported();
        }
        $cursor = $server->executeCommand($this->databaseName, $this->createCommand($server), $this->createOptions());
        if (isset($this->options['typeMap'])) {
            $cursor->setTypeMap($this->options['typeMap']);
        }
        return current($cursor->toArray());
    }

    private function createCommand(Server $server): Command
    {
        $cmd = ['explain' => $this->explainable->getCommandDocument($server)];
        foreach (['comment', 'verbosity'] as $option) {
            if (isset($this->options[$option])) {
                $cmd[$option] = $this->options[$option];
            }
        }
        return new Command($cmd);
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

    private function isFindAndModify(Explainable $explainable): bool
    {
        if ($explainable instanceof FindAndModify || $explainable instanceof FindOneAndDelete || $explainable instanceof FindOneAndReplace || $explainable instanceof FindOneAndUpdate) {
            return true;
        }
        return false;
    }
}