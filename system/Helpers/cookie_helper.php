<?php

use Config\App;
use Config\Cookie;
use Config\Services;

if (!function_exists('set_cookie')) {
    function set_cookie($name, string $value = '', string $expire = '', string $domain = '', string $path = '/', string $prefix = '', ?bool $secure = null, ?bool $httpOnly = null, ?string $sameSite = null)
    {
        $response = Services::response();
        $response->setCookie($name, $value, $expire, $domain, $path, $prefix, $secure, $httpOnly, $sameSite);
    }
}
if (!function_exists('get_cookie')) {
    function get_cookie($index, bool $xssClean = false, ?string $prefix = '')
    {
        if ($prefix === '') {
            $cookie = config('Cookie');
            $prefix = $cookie instanceof Cookie ? $cookie->prefix : config('App')->cookiePrefix;
        }
        $request = Services::request();
        $filter = $xssClean ? FILTER_SANITIZE_FULL_SPECIAL_CHARS : FILTER_DEFAULT;
        return $request->getCookie($prefix . $index, $filter);
    }
}
if (!function_exists('delete_cookie')) {
    function delete_cookie($name, string $domain = '', string $path = '/', string $prefix = '')
    {
        Services::response()->deleteCookie($name, $domain, $path, $prefix);
    }
}
if (!function_exists('has_cookie')) {
    function has_cookie(string $name, ?string $value = null, string $prefix = ''): bool
    {
        return Services::response()->hasCookie($name, $value, $prefix);
    }
}