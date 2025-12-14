<?php
if (!function_exists('dd')) {
    if (class_exists(Kint::class)) {
        function dd(...$vars)
        {
            Kint::$aliases[] = 'dd';
            Kint::dump(...$vars);
            exit;
        }
    } else {
        function dd(...$vars)
        {
            return 0;
        }
    }
}
if (!function_exists('d') && !class_exists(Kint::class)) {
    function d(...$vars)
    {
        return 0;
    }
}
if (!function_exists('trace')) {
    if (class_exists(Kint::class)) {
        function trace()
        {
            Kint::$aliases[] = 'trace';
            Kint::trace();
        }
    } else {
        function trace()
        {
            return 0;
        }
    }
}