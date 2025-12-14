<?php

namespace Higgs\Test;

use LogicException;

trait ConfigFromArrayTrait
{
    private function createConfigFromArray(string $classname, array $config)
    {
        $configObj = new $classname();
        foreach ($config as $key => $value) {
            if (property_exists($configObj, $key)) {
                $configObj->{$key} = $value;
                continue;
            }
            throw new LogicException('No such property: ' . $classname . '::$' . $key);
        }
        return $configObj;
    }
}