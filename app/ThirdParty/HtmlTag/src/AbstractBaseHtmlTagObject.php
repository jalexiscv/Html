<?php

namespace drupol\htmltag;

use function array_filter;
use function array_map;
use function array_merge;
use function array_shift;
use function array_values;
use function gettype;
use function is_array;
use function method_exists;

abstract class AbstractBaseHtmlTagObject
{
    protected function ensureFlatArray(array $data)
    {
        $flat = [];
        while (!empty($data)) {
            $value = array_shift($data);
            if (is_array($value)) {
                $data = array_merge($value, $data);
                continue;
            }
            $flat[] = $value;
        }
        return $flat;
    }

    protected function ensureString($data)
    {
        $return = null;
        switch (gettype($data)) {
            case 'string':
                $return = $data;
                break;
            case 'integer':
            case 'double':
                $return = (string)$data;
                break;
            case 'object':
                if (method_exists($data, '__toString')) {
                    $return = $data->__toString();
                }
                break;
            case 'boolean':
            case 'array':
            default:
                $return = null;
                break;
        }
        return $return;
    }

    protected function ensureStrings(array $values)
    {
        return array_values(array_filter(array_map([$this, 'ensureString'], $values), '\is_string'));
    }
}