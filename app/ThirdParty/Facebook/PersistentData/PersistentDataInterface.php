<?php

namespace Facebook\PersistentData;
interface PersistentDataInterface
{
    public function get($key);

    public function set($key, $value);
}