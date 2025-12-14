<?php

namespace Higgs\Test\Mock;

use Higgs\Events\Events;

class MockEvents extends Events
{
    public function getListeners()
    {
        return self::$listeners;
    }

    public function getEventsFile()
    {
        return self::$files;
    }

    public function getSimulate()
    {
        return self::$simulate;
    }

    public function unInitialize()
    {
        static::$initialized = false;
    }
}