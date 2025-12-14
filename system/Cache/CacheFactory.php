<?php

namespace Higgs\Cache;

use Higgs\Cache\Exceptions\CacheException;
use Higgs\Exceptions\CriticalError;
use Higgs\Test\Mock\MockCache;
use Config\Cache;

class CacheFactory
{
    public static $mockClass = MockCache::class;
    public static $mockServiceName = 'cache';

    public static function getHandler(Cache $config, ?string $handler = null, ?string $backup = null)
    {
        if (!isset($config->validHandlers) || $config->validHandlers === []) {
            throw CacheException::forInvalidHandlers();
        }
        if (!isset($config->handler) || !isset($config->backupHandler)) {
            throw CacheException::forNoBackup();
        }
        $handler = !empty($handler) ? $handler : $config->handler;
        $backup = !empty($backup) ? $backup : $config->backupHandler;
        if (!array_key_exists($handler, $config->validHandlers) || !array_key_exists($backup, $config->validHandlers)) {
            throw CacheException::forHandlerNotFound();
        }
        $adapter = new $config->validHandlers[$handler]($config);
        if (!$adapter->isSupported()) {
            $adapter = new $config->validHandlers[$backup]($config);
            if (!$adapter->isSupported()) {
                $adapter = new $config->validHandlers['dummy']();
            }
        }
        try {
            $adapter->initialize();
        } catch (CriticalError $e) {
            log_message('critical', $e . ' Resorting to using ' . $backup . ' handler.');
            $adapter = self::getHandler($config, $backup, 'dummy');
        }
        return $adapter;
    }
}