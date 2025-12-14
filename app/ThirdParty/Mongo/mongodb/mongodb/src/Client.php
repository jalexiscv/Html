<?php

namespace MongoDB;

use Iterator;
use Jean85\PrettyVersions;
use MongoDB\Driver\ClientEncryption;
use MongoDB\Driver\Exception\InvalidArgumentException as DriverInvalidArgumentException;
use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
use MongoDB\Driver\Manager;
use MongoDB\Driver\ReadConcern;
use MongoDB\Driver\ReadPreference;
use MongoDB\Driver\Session;
use MongoDB\Driver\WriteConcern;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnexpectedValueException;
use MongoDB\Exception\UnsupportedException;
use MongoDB\Model\BSONArray;
use MongoDB\Model\BSONDocument;
use MongoDB\Model\DatabaseInfoIterator;
use MongoDB\Operation\DropDatabase;
use MongoDB\Operation\ListDatabaseNames;
use MongoDB\Operation\ListDatabases;
use MongoDB\Operation\Watch;
use Throwable;
use function is_array;
use function is_string;

class Client
{
    public const DEFAULT_URI = 'mongodb://127.0.0.1/';
    private static $defaultTypeMap = ['array' => BSONArray::class, 'document' => BSONDocument::class, 'root' => BSONDocument::class,];
    private static $handshakeSeparator = ' / ';
    private static $version;
    private $manager;
    private $readConcern;
    private $readPreference;
    private $uri;
    private $typeMap;
    private $writeConcern;

    public function __construct(?string $uri = null, array $uriOptions = [], array $driverOptions = [])
    {
        $driverOptions += ['typeMap' => self::$defaultTypeMap];
        if (!is_array($driverOptions['typeMap'])) {
            throw InvalidArgumentException::invalidType('"typeMap" driver option', $driverOptions['typeMap'], 'array');
        }
        if (isset($driverOptions['autoEncryption']['keyVaultClient'])) {
            if ($driverOptions['autoEncryption']['keyVaultClient'] instanceof self) {
                $driverOptions['autoEncryption']['keyVaultClient'] = $driverOptions['autoEncryption']['keyVaultClient']->manager;
            } elseif (!$driverOptions['autoEncryption']['keyVaultClient'] instanceof Manager) {
                throw InvalidArgumentException::invalidType('"keyVaultClient" autoEncryption option', $driverOptions['autoEncryption']['keyVaultClient'], [self::class, Manager::class]);
            }
        }
        $driverOptions['driver'] = $this->mergeDriverInfo($driverOptions['driver'] ?? []);
        $this->uri = $uri ?? self::DEFAULT_URI;
        $this->typeMap = $driverOptions['typeMap'];
        unset($driverOptions['typeMap']);
        $this->manager = new Manager($uri, $uriOptions, $driverOptions);
        $this->readConcern = $this->manager->getReadConcern();
        $this->readPreference = $this->manager->getReadPreference();
        $this->writeConcern = $this->manager->getWriteConcern();
    }

    public function __debugInfo()
    {
        return ['manager' => $this->manager, 'uri' => $this->uri, 'typeMap' => $this->typeMap, 'writeConcern' => $this->writeConcern,];
    }

    public function __get(string $databaseName)
    {
        return $this->selectDatabase($databaseName);
    }

    public function __toString()
    {
        return $this->uri;
    }

    public function createClientEncryption(array $options)
    {
        if (isset($options['keyVaultClient'])) {
            if ($options['keyVaultClient'] instanceof self) {
                $options['keyVaultClient'] = $options['keyVaultClient']->manager;
            } elseif (!$options['keyVaultClient'] instanceof Manager) {
                throw InvalidArgumentException::invalidType('"keyVaultClient" option', $options['keyVaultClient'], [self::class, Manager::class]);
            }
        }
        return $this->manager->createClientEncryption($options);
    }

    public function dropDatabase(string $databaseName, array $options = [])
    {
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->typeMap;
        }
        $server = select_server($this->manager, $options);
        if (!isset($options['writeConcern']) && !is_in_transaction($options)) {
            $options['writeConcern'] = $this->writeConcern;
        }
        $operation = new DropDatabase($databaseName, $options);
        return $operation->execute($server);
    }

    public function getManager()
    {
        return $this->manager;
    }

    public function getReadConcern()
    {
        return $this->readConcern;
    }

    public function getReadPreference()
    {
        return $this->readPreference;
    }

    public function getTypeMap()
    {
        return $this->typeMap;
    }

    public function getWriteConcern()
    {
        return $this->writeConcern;
    }

    public function listDatabaseNames(array $options = []): Iterator
    {
        $operation = new ListDatabaseNames($options);
        $server = select_server($this->manager, $options);
        return $operation->execute($server);
    }

    public function listDatabases(array $options = [])
    {
        $operation = new ListDatabases($options);
        $server = select_server($this->manager, $options);
        return $operation->execute($server);
    }

    public function selectCollection(string $databaseName, string $collectionName, array $options = [])
    {
        $options += ['typeMap' => $this->typeMap];
        return new Collection($this->manager, $databaseName, $collectionName, $options);
    }

    public function selectDatabase(string $databaseName, array $options = [])
    {
        $options += ['typeMap' => $this->typeMap];
        return new Database($this->manager, $databaseName, $options);
    }

    public function startSession(array $options = [])
    {
        return $this->manager->startSession($options);
    }

    public function watch(array $pipeline = [], array $options = [])
    {
        if (!isset($options['readPreference']) && !is_in_transaction($options)) {
            $options['readPreference'] = $this->readPreference;
        }
        $server = select_server($this->manager, $options);
        if (!isset($options['readConcern']) && !is_in_transaction($options)) {
            $options['readConcern'] = $this->readConcern;
        }
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = $this->typeMap;
        }
        $operation = new Watch($this->manager, null, null, $pipeline, $options);
        return $operation->execute($server);
    }

    private static function getVersion(): string
    {
        if (self::$version === null) {
            try {
                self::$version = PrettyVersions::getVersion('mongodb/mongodb')->getPrettyVersion();
            } catch (Throwable $t) {
                return 'unknown';
            }
        }
        return self::$version;
    }

    private function mergeDriverInfo(array $driver): array
    {
        $mergedDriver = ['name' => 'PHPLIB', 'version' => self::getVersion(),];
        if (isset($driver['name'])) {
            if (!is_string($driver['name'])) {
                throw InvalidArgumentException::invalidType('"name" handshake option', $driver['name'], 'string');
            }
            $mergedDriver['name'] .= self::$handshakeSeparator . $driver['name'];
        }
        if (isset($driver['version'])) {
            if (!is_string($driver['version'])) {
                throw InvalidArgumentException::invalidType('"version" handshake option', $driver['version'], 'string');
            }
            $mergedDriver['version'] .= self::$handshakeSeparator . $driver['version'];
        }
        if (isset($driver['platform'])) {
            $mergedDriver['platform'] = $driver['platform'];
        }
        return $mergedDriver;
    }
}