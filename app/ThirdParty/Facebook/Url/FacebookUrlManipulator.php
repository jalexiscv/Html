<?php

namespace Facebook\Url;
class FacebookUrlManipulator
{
    public static function removeParamsFromUrl($url, array $paramsToFilter)
    {
        $parts = parse_url($url);
        $query = '';
        if (isset($parts['query'])) {
            $params = [];
            parse_str($parts['query'], $params);
            foreach ($paramsToFilter as $paramName) {
                unset($params[$paramName]);
            }
            if (count($params) > 0) {
                $query = '?' . http_build_query($params, null, '&');
            }
        }
        $scheme = isset($parts['scheme']) ? $parts['scheme'] . '://' : '';
        $host = isset($parts['host']) ? $parts['host'] : '';
        $port = isset($parts['port']) ? ':' . $parts['port'] : '';
        $path = isset($parts['path']) ? $parts['path'] : '';
        $fragment = isset($parts['fragment']) ? '#' . $parts['fragment'] : '';
        return $scheme . $host . $port . $path . $query . $fragment;
    }

    public static function appendParamsToUrl($url, array $newParams = [])
    {
        if (empty($newParams)) {
            return $url;
        }
        if (strpos($url, '?') === false) {
            return $url . '?' . http_build_query($newParams, null, '&');
        }
        list($path, $query) = explode('?', $url, 2);
        $existingParams = [];
        parse_str($query, $existingParams);
        $newParams = array_merge($newParams, $existingParams);
        ksort($newParams);
        return $path . '?' . http_build_query($newParams, null, '&');
    }

    public static function getParamsAsArray($url)
    {
        $query = parse_url($url, PHP_URL_QUERY);
        if (!$query) {
            return [];
        }
        $params = [];
        parse_str($query, $params);
        return $params;
    }

    public static function mergeUrlParams($urlToStealFrom, $urlToAddTo)
    {
        $newParams = static::getParamsAsArray($urlToStealFrom);
        if (!$newParams) {
            return $urlToAddTo;
        }
        return static::appendParamsToUrl($urlToAddTo, $newParams);
    }

    public static function forceSlashPrefix($string)
    {
        if (!$string) {
            return $string;
        }
        return strpos($string, '/') === 0 ? $string : '/' . $string;
    }

    public static function baseGraphUrlEndpoint($urlToTrim)
    {
        return '/' . preg_replace('/^https:\/\/.+\.facebook\.com(\/v.+?)?\//', '', $urlToTrim);
    }
}