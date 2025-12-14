<?php

namespace Facebook\PersistentData;

use Facebook\Exceptions\FacebookSDKException;

class FacebookSessionPersistentDataHandler implements PersistentDataInterface
{
    protected $sessionPrefix = 'FBRLH_';

    public function __construct($enableSessionCheck = true)
    {
        if ($enableSessionCheck && session_status() !== PHP_SESSION_ACTIVE) {
            throw new FacebookSDKException('Sessions are not active. Please make sure session_start() is at the top of your script.', 720);
        }
    }

    public function get($key)
    {
        if (isset($_SESSION[$this->sessionPrefix . $key])) {
            return $_SESSION[$this->sessionPrefix . $key];
        }
        return null;
    }

    public function set($key, $value)
    {
        $_SESSION[$this->sessionPrefix . $key] = $value;
    }
}