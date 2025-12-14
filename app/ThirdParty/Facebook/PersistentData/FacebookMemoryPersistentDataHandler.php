<?php

namespace Facebook\PersistentData;
class FacebookMemoryPersistentDataHandler implements PersistentDataInterface
{
    protected $sessionData = [];

    public function get($key)
    {
        return isset($this->sessionData[$key]) ? $this->sessionData[$key] : null;
    }

    public function set($key, $value)
    {
        $this->sessionData[$key] = $value;
    }
}