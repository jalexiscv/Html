<?php

namespace Facebook\PersistentData;

use InvalidArgumentException;

class PersistentDataFactory
{
    private function __construct()
    {
    }

    public static function createPersistentDataHandler($handler)
    {
        if (!$handler) {
            return session_status() === PHP_SESSION_ACTIVE ? new FacebookSessionPersistentDataHandler() : new FacebookMemoryPersistentDataHandler();
        }
        if ($handler instanceof PersistentDataInterface) {
            return $handler;
        }
        if ('session' === $handler) {
            return new FacebookSessionPersistentDataHandler();
        }
        if ('memory' === $handler) {
            return new FacebookMemoryPersistentDataHandler();
        }
        throw new InvalidArgumentException('The persistent data handler must be set to "session", "memory", or be an instance of Facebook\PersistentData\PersistentDataInterface');
    }
}