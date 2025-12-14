<?php

declare(strict_types=1);

namespace Higgs\Html;

use Stringable;
use function gettype;
use function is_array;

/**
 * Class AbstractBaseHtmlTagObject.
 *
 * This class is the base class of other HTMLTag objects.
 * It contains simple methods that are needed everywhere.
 */
abstract class AbstractBaseHtmlTagObject
{
    /**
     * Transform a multidimensional array into a flat array.
     *
     * @param array<mixed> $data The input array
     * @return array<mixed> A simple array
     */
    protected function ensureFlatArray(array $data): array
    {
        $flat = [];
        array_walk_recursive($data, function ($a) use (&$flat) {
            $flat[] = $a;
        });
        return $flat;
    }

    /**
     * Convert a value into a string when it's possible.
     *
     * @param mixed $data The input value
     * @return string|null The value converted as a string or null
     */
    protected function ensureString(mixed $data): ?string
    {
        return match (true) {
            is_string($data) => $data,
            is_numeric($data) => (string)$data,
            $data instanceof Stringable || (is_object($data) && method_exists($data, '__toString')) => (string)$data,
            default => null,
        };
    }

    /**
     * Make sure that the value parameters is converted into an array of strings.
     *
     * @param array<mixed> $values The input values
     * @return array<string> The output values
     */
    protected function ensureStrings(array $values): array
    {
        $strings = [];
        foreach ($values as $value) {
            $str = $this->ensureString($value);
            if ($str !== null) {
                $strings[] = $str;
            }
        }
        return $strings;
    }
}
