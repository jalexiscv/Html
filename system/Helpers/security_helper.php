<?php

use Config\Services;

if (!function_exists('sanitize_filename')) {
    function sanitize_filename(string $filename): string
    {
        return Services::security()->sanitizeFilename($filename);
    }
}
if (!function_exists('strip_image_tags')) {
    function strip_image_tags(string $str): string
    {
        return preg_replace(['#<img[\s/]+.*?src\s*=\s*(["\'])([^\\1]+?)\\1.*?\>#i', '#<img[\s/]+.*?src\s*=\s*?(([^\s"\'=<>`]+)).*?\>#i',], '\\2', $str);
    }
}
if (!function_exists('encode_php_tags')) {
    function encode_php_tags(string $str): string
    {
        return str_replace(['<?', '?>'], ['&lt;?', '?&gt;'], $str);
    }
}