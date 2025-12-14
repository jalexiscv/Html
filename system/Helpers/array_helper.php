<?php
if (!function_exists('dot_array_search')) {
    function dot_array_search(string $index, array $array)
    {
        $segments = preg_split('/(?<!\\\\)\./', rtrim($index, '* '), 0, PREG_SPLIT_NO_EMPTY);
        $segments = array_map(static fn($key) => str_replace('\.', '.', $key), $segments);
        return _array_search_dot($segments, $array);
    }
}
if (!function_exists('_array_search_dot')) {
    function _array_search_dot(array $indexes, array $array)
    {
        if ($indexes === []) {
            return null;
        }
        $currentIndex = array_shift($indexes);
        if (!isset($array[$currentIndex]) && $currentIndex !== '*') {
            return null;
        }
        if ($currentIndex === '*') {
            $answer = [];
            foreach ($array as $value) {
                if (!is_array($value)) {
                    return null;
                }
                $answer[] = _array_search_dot($indexes, $value);
            }
            $answer = array_filter($answer, static fn($value) => $value !== null);
            if ($answer !== []) {
                if (count($answer) === 1) {
                    return current($answer);
                }
                return $answer;
            }
            return null;
        }
        if (empty($indexes)) {
            return $array[$currentIndex];
        }
        if (is_array($array[$currentIndex]) && $array[$currentIndex] !== []) {
            return _array_search_dot($indexes, $array[$currentIndex]);
        }
        return null;
    }
}
if (!function_exists('array_deep_search')) {
    function array_deep_search($key, array $array)
    {
        if (isset($array[$key])) {
            return $array[$key];
        }
        foreach ($array as $value) {
            if (is_array($value) && ($result = array_deep_search($key, $value))) {
                return $result;
            }
        }
        return null;
    }
}
if (!function_exists('array_sort_by_multiple_keys')) {
    function array_sort_by_multiple_keys(array &$array, array $sortColumns): bool
    {
        if (empty($sortColumns) || empty($array)) {
            return false;
        }
        $tempArray = [];
        foreach ($sortColumns as $key => $sortFlag) {
            $carry = $array;
            foreach (explode('.', $key) as $keySegment) {
                if (is_object(reset($carry))) {
                    foreach ($carry as $index => $object) {
                        $carry[$index] = $object->{$keySegment};
                    }
                    continue;
                }
                $carry = array_column($carry, $keySegment);
            }
            $tempArray[] = $carry;
            $tempArray[] = $sortFlag;
        }
        $tempArray[] = &$array;
        return array_multisort(...$tempArray);
    }
}
if (!function_exists('array_flatten_with_dots')) {
    function array_flatten_with_dots(iterable $array, string $id = ''): array
    {
        $flattened = [];
        foreach ($array as $key => $value) {
            $newKey = $id . $key;
            if (is_array($value) && $value !== []) {
                $flattened = array_merge($flattened, array_flatten_with_dots($value, $newKey . '.'));
            } else {
                $flattened[$newKey] = $value;
            }
        }
        return $flattened;
    }
}