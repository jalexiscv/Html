<?php

use Higgs\HTTP\CLIRequest;
use Higgs\HTTP\Exceptions\HTTPException;
use Higgs\HTTP\IncomingRequest;
use Higgs\HTTP\URI;
use Higgs\Router\Exceptions\RouterException;
use Config\App;
use Config\Services;

if (!function_exists('_get_uri')) {
    function _get_uri(string $relativePath = '', ?App $config = null): URI
    {
        $config ??= config('App');
        if ($config->baseURL === '') {
            throw new InvalidArgumentException('_get_uri() requires a valid baseURL.');
        }
        if (strpos($relativePath, '://') !== false) {
            $full = new URI($relativePath);
            $relativePath = URI::createURIString(null, null, $full->getPath(), $full->getQuery(), $full->getFragment());
        }
        $relativePath = URI::removeDotSegments($relativePath);
        $request = Services::request();
        if ($request instanceof CLIRequest) {
            $url = rtrim($config->baseURL, '/ ') . '/';
        } else {
            $url = $request->getUri()->getBaseURL();
        }
        if ($config->indexPage !== '') {
            $url .= $config->indexPage;
            if ($relativePath !== '' && $relativePath[0] !== '/' && $relativePath[0] !== '?') {
                $url .= '/';
            }
        }
        $url .= $relativePath;
        $uri = new URI($url);
        if ($config->forceGlobalSecureRequests && $uri->getScheme() === 'http') {
            $uri->setScheme('https');
        }
        return $uri;
    }
}
if (!function_exists('site_url')) {
    function site_url($relativePath = '', ?string $scheme = null, ?App $config = null): string
    {
        if (is_array($relativePath)) {
            $relativePath = implode('/', $relativePath);
        }
        $uri = _get_uri($relativePath, $config);
        $return = URI::createURIString($scheme ?? $uri->getScheme(), $uri->getAuthority(), $uri->getPath(), $uri->getQuery(), $uri->getFragment());
        return (str_replace("index.php/", "", $return));
    }
}
if (!function_exists('base_url')) {
    function base_url($relativePath = '', ?string $scheme = null): string
    {
        $config = clone config('App');
        $config->indexPage = '';
        return rtrim(site_url($relativePath, $scheme, $config), '/');
    }
}
if (!function_exists('current_url')) {
    function current_url(bool $returnObject = false, ?IncomingRequest $request = null)
    {
        $request ??= Services::request();
        $path = $request->getPath();
        if ($query = $request->getUri()->getQuery()) {
            $path .= '?' . $query;
        }
        if ($fragment = $request->getUri()->getFragment()) {
            $path .= '#' . $fragment;
        }
        $uri = _get_uri($path);
        return $returnObject ? $uri : URI::createURIString($uri->getScheme(), $uri->getAuthority(), $uri->getPath());
    }
}
if (!function_exists('previous_url')) {
    function previous_url(bool $returnObject = false)
    {
        $referer = $_SESSION['_ci_previous_url'] ?? Services::request()->getServer('HTTP_REFERER', FILTER_SANITIZE_URL);
        $referer ??= site_url('/');
        return $returnObject ? new URI($referer) : $referer;
    }
}
if (!function_exists('uri_string')) {
    function uri_string(bool $relative = false): string
    {
        return $relative ? ltrim(Services::request()->getPath(), '/') : Services::request()->getUri()->getPath();
    }
}
if (!function_exists('index_page')) {
    function index_page(?App $altConfig = null): string
    {
        $config = $altConfig ?? config('App');
        return $config->indexPage;
    }
}
if (!function_exists('anchor')) {
    function anchor($uri = '', string $title = '', $attributes = '', ?App $altConfig = null): string
    {
        $config = $altConfig ?? config('App');
        $siteUrl = is_array($uri) ? site_url($uri, null, $config) : (preg_match('#^(\w+:)?//#i', $uri) ? $uri : site_url($uri, null, $config));
        $siteUrl = rtrim($siteUrl, '/');
        if ($title === '') {
            $title = $siteUrl;
        }
        if ($attributes !== '') {
            $attributes = stringify_attributes($attributes);
        }
        return '<a href="' . $siteUrl . '"' . $attributes . '>' . $title . '</a>';
    }
}
if (!function_exists('anchor_popup')) {
    function anchor_popup($uri = '', string $title = '', $attributes = false, ?App $altConfig = null): string
    {
        $config = $altConfig ?? config('App');
        $siteUrl = preg_match('#^(\w+:)?//#i', $uri) ? $uri : site_url($uri, null, $config);
        $siteUrl = rtrim($siteUrl, '/');
        if ($title === '') {
            $title = $siteUrl;
        }
        if ($attributes === false) {
            return '<a href="' . $siteUrl . '" onclick="window.open(\'' . $siteUrl . "', '_blank'); return false;\">" . $title . '</a>';
        }
        if (!is_array($attributes)) {
            $attributes = [$attributes];
            $windowName = '_blank';
        } elseif (!empty($attributes['window_name'])) {
            $windowName = $attributes['window_name'];
            unset($attributes['window_name']);
        } else {
            $windowName = '_blank';
        }
        foreach (['width' => '800', 'height' => '600', 'scrollbars' => 'yes', 'menubar' => 'no', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0'] as $key => $val) {
            $atts[$key] = $attributes[$key] ?? $val;
            unset($attributes[$key]);
        }
        $attributes = stringify_attributes($attributes);
        return '<a href="' . $siteUrl . '" onclick="window.open(\'' . $siteUrl . "', '" . $windowName . "', '" . stringify_attributes($atts, true) . "'); return false;\"" . $attributes . '>' . $title . '</a>';
    }
}
if (!function_exists('mailto')) {
    function mailto(string $email, string $title = '', $attributes = ''): string
    {
        if (trim($title) === '') {
            $title = $email;
        }
        return '<a href="mailto:' . $email . '"' . stringify_attributes($attributes) . '>' . $title . '</a>';
    }
}
if (!function_exists('safe_mailto')) {
    function safe_mailto(string $email, string $title = '', $attributes = ''): string
    {
        if (trim($title) === '') {
            $title = $email;
        }
        $x = str_split('<a href="mailto:', 1);
        for ($i = 0, $l = strlen($email); $i < $l; $i++) {
            $x[] = '|' . ord($email[$i]);
        }
        $x[] = '"';
        if ($attributes !== '') {
            if (is_array($attributes)) {
                foreach ($attributes as $key => $val) {
                    $x[] = ' ' . $key . '="';
                    for ($i = 0, $l = strlen($val); $i < $l; $i++) {
                        $x[] = '|' . ord($val[$i]);
                    }
                    $x[] = '"';
                }
            } else {
                for ($i = 0, $l = mb_strlen($attributes); $i < $l; $i++) {
                    $x[] = mb_substr($attributes, $i, 1);
                }
            }
        }
        $x[] = '>';
        $temp = [];
        for ($i = 0, $l = strlen($title); $i < $l; $i++) {
            $ordinal = ord($title[$i]);
            if ($ordinal < 128) {
                $x[] = '|' . $ordinal;
            } else {
                if (empty($temp)) {
                    $count = ($ordinal < 224) ? 2 : 3;
                }
                $temp[] = $ordinal;
                if (count($temp) === $count) {
                    $number = ($count === 3) ? (($temp[0] % 16) * 4096) + (($temp[1] % 64) * 64) + ($temp[2] % 64) : (($temp[0] % 32) * 64) + ($temp[1] % 64);
                    $x[] = '|' . $number;
                    $count = 1;
                    $temp = [];
                }
            }
        }
        $x[] = '<';
        $x[] = '/';
        $x[] = 'a';
        $x[] = '>';
        $x = array_reverse($x);
        $cspNonce = csp_script_nonce();
        $cspNonce = $cspNonce ? ' ' . $cspNonce : $cspNonce;
        $output = '<script' . $cspNonce . '>' . 'var l=new Array();';
        foreach ($x as $i => $value) {
            $output .= 'l[' . $i . "] = '" . $value . "';";
        }
        return $output . ('for (var i = l.length-1; i >= 0; i=i-1) {' . "if (l[i].substring(0, 1) === '|') document.write(\"&#\"+unescape(l[i].substring(1))+\";\");" . 'else document.write(unescape(l[i]));' . '}' . '</script>');
    }
}
if (!function_exists('auto_link')) {
    function auto_link(string $str, string $type = 'both', bool $popup = false): string
    {
        if ($type !== 'email' && preg_match_all('#(\w*://|www\.)[^\s()<>;]+\w#i', $str, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER)) {
            $target = ($popup) ? ' target="_blank"' : '';
            foreach (array_reverse($matches) as $match) {
                $a = '<a href="' . (strpos($match[1][0], '/') ? '' : 'http://') . $match[0][0] . '"' . $target . '>' . $match[0][0] . '</a>';
                $str = substr_replace($str, $a, $match[0][1], strlen($match[0][0]));
            }
        }
        if ($type !== 'url' && preg_match_all('#([\w\.\-\+]+@[a-z0-9\-]+\.[a-z0-9\-\.]+[^[:punct:]\s])#i', $str, $matches, PREG_OFFSET_CAPTURE)) {
            foreach (array_reverse($matches[0]) as $match) {
                if (filter_var($match[0], FILTER_VALIDATE_EMAIL) !== false) {
                    $str = substr_replace($str, safe_mailto($match[0]), $match[1], strlen($match[0]));
                }
            }
        }
        return $str;
    }
}
if (!function_exists('prep_url')) {
    function prep_url(string $str = '', bool $secure = false): string
    {
        if (in_array($str, ['http://', 'https://', '//', ''], true)) {
            return '';
        }
        if (parse_url($str, PHP_URL_SCHEME) === null) {
            $str = 'http://' . ltrim($str, '/');
        }
        if ($secure) {
            $str = preg_replace('/^(?:http):/i', 'https:', $str);
        }
        return $str;
    }
}
if (!function_exists('url_title')) {
    function url_title(string $str, string $separator = '-', bool $lowercase = false): string
    {
        $qSeparator = preg_quote($separator, '#');
        $trans = ['&.+?;' => '', '[^\w\d\pL\pM _-]' => '', '\s+' => $separator, '(' . $qSeparator . ')+' => $separator,];
        $str = strip_tags($str);
        foreach ($trans as $key => $val) {
            $str = preg_replace('#' . $key . '#iu', $val, $str);
        }
        if ($lowercase === true) {
            $str = mb_strtolower($str);
        }
        return trim(trim($str, $separator));
    }
}
if (!function_exists('mb_url_title')) {
    function mb_url_title(string $str, string $separator = '-', bool $lowercase = false): string
    {
        helper('text');
        return url_title(convert_accented_characters($str), $separator, $lowercase);
    }
}
if (!function_exists('url_to')) {
    function url_to(string $controller, ...$args): string
    {
        if (!$route = route_to($controller, ...$args)) {
            $explode = explode('::', $controller);
            if (isset($explode[1])) {
                throw RouterException::forControllerNotFound($explode[0], $explode[1]);
            }
            throw RouterException::forInvalidRoute($controller);
        }
        return site_url($route);
    }
}
if (!function_exists('url_is')) {
    function url_is(string $path): bool
    {
        $path = '/' . trim(str_replace('*', '(\S)*', $path), '/ ');
        $currentPath = '/' . trim(uri_string(true), '/ ');
        return (bool)preg_match("|^{$path}$|", $currentPath, $matches);
    }
}