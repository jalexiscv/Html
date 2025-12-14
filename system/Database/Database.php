<?php

namespace Higgs\Database;

use InvalidArgumentException;

class Database
{
    protected $connections = [];

    public function load(array $params = [], string $alias = '')
    {
        if ($alias === '') {
            throw new InvalidArgumentException('You must supply the parameter: alias.');
        }
        if (!empty($params['DSN']) && strpos($params['DSN'], '://') !== false) {
            $params = $this->parseDSN($params);
        }
        if (empty($params['DBDriver'])) {
            throw new InvalidArgumentException('You have not selected a database type to connect to.');
        }
        $this->connections[$alias] = $this->initDriver($params['DBDriver'], 'Connection', $params);
        return $this->connections[$alias];
    }

    protected function parseDSN(array $params): array
    {
        $dsn = parse_url($params['DSN']);
        if (!$dsn) {
            throw new InvalidArgumentException('Your DSN connection string is invalid.');
        }
        $dsnParams = ['DSN' => '', 'DBDriver' => $dsn['scheme'], 'hostname' => isset($dsn['host']) ? rawurldecode($dsn['host']) : '', 'port' => isset($dsn['port']) ? rawurldecode((string)$dsn['port']) : '', 'username' => isset($dsn['user']) ? rawurldecode($dsn['user']) : '', 'password' => isset($dsn['pass']) ? rawurldecode($dsn['pass']) : '', 'database' => isset($dsn['path']) ? rawurldecode(substr($dsn['path'], 1)) : '',];
        if (!empty($dsn['query'])) {
            parse_str($dsn['query'], $extra);
            foreach ($extra as $key => $val) {
                if (is_string($val) && in_array(strtolower($val), ['true', 'false', 'null'], true)) {
                    $val = $val === 'null' ? null : filter_var($val, FILTER_VALIDATE_BOOLEAN);
                }
                $dsnParams[$key] = $val;
            }
        }
        return array_merge($params, $dsnParams);
    }

    protected function initDriver(string $driver, string $class, $argument): object
    {
        $class = $driver . '\\' . $class;
        if (strpos($driver, '\\') === false) {
            $class = "Higgs\\Database\\{$class}";
        }
        return new $class($argument);
    }

    public function loadForge(ConnectionInterface $db): Forge
    {
        if (!$db->connID) {
            $db->initialize();
        }
        return $this->initDriver($db->DBDriver, 'Forge', $db);
    }

    public function loadUtils(ConnectionInterface $db): BaseUtils
    {
        if (!$db->connID) {
            $db->initialize();
        }
        return $this->initDriver($db->DBDriver, 'Utils', $db);
    }
}