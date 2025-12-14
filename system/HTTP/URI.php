<?php

namespace Higgs\HTTP;

use BadMethodCallException;
use Higgs\HTTP\Exceptions\HTTPException;

class URI
{
    public const CHAR_SUB_DELIMS = '!\$&\'\(\)\*\+,;=';
    public const CHAR_UNRESERVED = 'a-zA-Z0-9_\-\.~';
    protected $uriString;
    protected $segments = [];
    protected $scheme = 'http';
    protected $user;
    protected $password;
    protected $host;
    protected $port;
    protected $path;
    protected $fragment = '';
    protected $query = [];
    protected $defaultPorts = ['http' => 80, 'https' => 443, 'ftp' => 21, 'sftp' => 22,];
    protected $showPassword = false;
    protected $silent = false;
    protected $rawQueryString = false;
    private ?string $baseURL = null;

    public function __construct(?string $uri = null)
    {
        if ($uri !== null) {
            $this->setURI($uri);
        }
    }

    public function setURI(?string $uri = null)
    {
        if ($uri !== null) {
            $parts = parse_url($uri);
            if ($parts === false) {
                if ($this->silent) {
                    return $this;
                }
                throw HTTPException::forUnableToParseURI($uri);
            }
            $this->applyParts($parts);
        }
        return $this;
    }

    protected function applyParts(array $parts)
    {
        if (!empty($parts['host'])) {
            $this->host = $parts['host'];
        }
        if (!empty($parts['user'])) {
            $this->user = $parts['user'];
        }
        if (isset($parts['path']) && $parts['path'] !== '') {
            $this->path = $this->filterPath($parts['path']);
        }
        if (!empty($parts['query'])) {
            $this->setQuery($parts['query']);
        }
        if (!empty($parts['fragment'])) {
            $this->fragment = $parts['fragment'];
        }
        if (isset($parts['scheme'])) {
            $this->setScheme(rtrim($parts['scheme'], ':/'));
        } else {
            $this->setScheme('http');
        }
        if (isset($parts['port']) && $parts['port'] !== null) {
            $this->port = $parts['port'];
        }
        if (isset($parts['pass'])) {
            $this->password = $parts['pass'];
        }
        if (isset($parts['path']) && $parts['path'] !== '') {
            $tempPath = trim($parts['path'], '/');
            $this->segments = ($tempPath === '') ? [] : explode('/', $tempPath);
        }
    }

    protected function filterPath(?string $path = null): string
    {
        $orig = $path;
        $path = urldecode($path);
        $path = self::removeDotSegments($path);
        if (strpos($orig, './') === 0) {
            $path = '/' . $path;
        }
        if (strpos($orig, '../') === 0) {
            $path = '/' . $path;
        }
        $path = preg_replace_callback('/(?:[^' . static::CHAR_UNRESERVED . ':@&=\+\$,\/;%]+|%(?![A-Fa-f0-9]{2}))/', static fn(array $matches) => rawurlencode($matches[0]), $path);
        return $path;
    }

    public static function removeDotSegments(string $path): string
    {
        if ($path === '' || $path === '/') {
            return $path;
        }
        $output = [];
        $input = explode('/', $path);
        if ($input[0] === '') {
            unset($input[0]);
            $input = array_values($input);
        }
        foreach ($input as $segment) {
            if ($segment === '..') {
                array_pop($output);
            } elseif ($segment !== '.' && $segment !== '') {
                $output[] = $segment;
            }
        }
        $output = implode('/', $output);
        $output = trim($output, '/ ');
        if (strpos($path, '/') === 0) {
            $output = '/' . $output;
        }
        if ($output !== '/' && substr($path, -1, 1) === '/') {
            $output .= '/';
        }
        return $output;
    }

    public function setSilent(bool $silent = true)
    {
        $this->silent = $silent;
        return $this;
    }

    public function useRawQueryString(bool $raw = true)
    {
        $this->rawQueryString = $raw;
        return $this;
    }

    public function showPassword(bool $val = true)
    {
        $this->showPassword = $val;
        return $this;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function setPort(?int $port = null)
    {
        if ($port === null) {
            return $this;
        }
        if ($port <= 0 || $port > 65535) {
            if ($this->silent) {
                return $this;
            }
            throw HTTPException::forInvalidPort($port);
        }
        $this->port = $port;
        return $this;
    }

    public function getSegments(): array
    {
        return $this->segments;
    }

    public function getSegment(int $number, string $default = ''): string
    {
        $number--;
        if ($number > count($this->segments) && !$this->silent) {
            throw HTTPException::forURISegmentOutOfRange($number);
        }
        return $this->segments[$number] ?? $default;
    }

    public function setSegment(int $number, $value)
    {
        $number--;
        if ($number > count($this->segments) + 1) {
            if ($this->silent) {
                return $this;
            }
            throw HTTPException::forURISegmentOutOfRange($number);
        }
        $this->segments[$number] = $value;
        $this->refreshPath();
        return $this;
    }

    public function refreshPath()
    {
        $this->path = $this->filterPath(implode('/', $this->segments));
        $tempPath = trim($this->path, '/');
        $this->segments = ($tempPath === '') ? [] : explode('/', $tempPath);
        return $this;
    }

    public function getTotalSegments(): int
    {
        return count($this->segments);
    }

    public function __toString(): string
    {
        $path = $this->getPath();
        $scheme = $this->getScheme();
        [$scheme, $path] = $this->changeSchemeAndPath($scheme, $path);
        return static::createURIString($scheme, $this->getAuthority(), $path, $this->getQuery(), $this->getFragment());
    }

    public function getPath(): string
    {
        return $this->path ?? '';
    }

    public function setPath(string $path)
    {
        $this->path = $this->filterPath($path);
        $tempPath = trim($this->path, '/');
        $this->segments = ($tempPath === '') ? [] : explode('/', $tempPath);
        return $this;
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function setScheme(string $str)
    {
        $str = strtolower($str);
        $this->scheme = preg_replace('#:(//)?$#', '', $str);
        return $this;
    }

    private function changeSchemeAndPath(string $scheme, string $path): array
    {
        $config = config('App');
        $baseUri = new self($config->baseURL);
        if (substr($this->getScheme(), 0, 4) === 'http' && $this->getHost() === $baseUri->getHost()) {
            $basePath = trim($baseUri->getPath(), '/') . '/';
            $trimPath = ltrim($path, '/');
            if ($basePath !== '/' && strpos($trimPath, $basePath) !== 0) {
                $path = $basePath . $trimPath;
            }
            if ($config->forceGlobalSecureRequests) {
                $scheme = 'https';
            }
        }
        return [$scheme, $path];
    }

    public function getHost(): string
    {
        return $this->host ?? '';
    }

    public function setHost(string $str)
    {
        $this->host = trim($str);
        return $this;
    }

    public static function createURIString(?string $scheme = null, ?string $authority = null, ?string $path = null, ?string $query = null, ?string $fragment = null): string
    {
        $uri = '';
        if (!empty($scheme)) {
            $uri .= $scheme . '://';
        }
        if (!empty($authority)) {
            $uri .= $authority;
        }
        if (isset($path) && $path !== '') {
            $uri .= substr($uri, -1, 1) !== '/' ? '/' . ltrim($path, '/') : ltrim($path, '/');
        }
        if ($query) {
            $uri .= '?' . $query;
        }
        if ($fragment) {
            $uri .= '#' . $fragment;
        }
        return $uri;
    }

    public function getAuthority(bool $ignorePort = false): string
    {
        if (empty($this->host)) {
            return '';
        }
        $authority = $this->host;
        if (!empty($this->getUserInfo())) {
            $authority = $this->getUserInfo() . '@' . $authority;
        }
        if (!empty($this->port) && !$ignorePort && $this->port !== $this->defaultPorts[$this->scheme]) {
            $authority .= ':' . $this->port;
        }
        $this->showPassword = false;
        return $authority;
    }

    public function getUserInfo()
    {
        $userInfo = $this->user;
        if ($this->showPassword === true && !empty($this->password)) {
            $userInfo .= ':' . $this->password;
        }
        return $userInfo;
    }

    public function getQuery(array $options = []): string
    {
        $vars = $this->query;
        if (array_key_exists('except', $options)) {
            if (!is_array($options['except'])) {
                $options['except'] = [$options['except']];
            }
            foreach ($options['except'] as $var) {
                unset($vars[$var]);
            }
        } elseif (array_key_exists('only', $options)) {
            $temp = [];
            if (!is_array($options['only'])) {
                $options['only'] = [$options['only']];
            }
            foreach ($options['only'] as $var) {
                if (array_key_exists($var, $vars)) {
                    $temp[$var] = $vars[$var];
                }
            }
            $vars = $temp;
        }
        return empty($vars) ? '' : http_build_query($vars);
    }

    public function setQuery(string $query)
    {
        if (strpos($query, '#') !== false) {
            if ($this->silent) {
                return $this;
            }
            throw HTTPException::forMalformedQueryString();
        }
        if (!empty($query) && strpos($query, '?') === 0) {
            $query = substr($query, 1);
        }
        if ($this->rawQueryString) {
            $this->query = $this->parseStr($query);
        } else {
            parse_str($query, $this->query);
        }
        return $this;
    }

    public function getFragment(): string
    {
        return $this->fragment ?? '';
    }

    public function setFragment(string $string)
    {
        $this->fragment = trim($string, '# ');
        return $this;
    }

    public function setUserInfo(string $user, string $pass)
    {
        $this->user = trim($user);
        $this->password = trim($pass);
        return $this;
    }

    public function getBaseURL(): string
    {
        if ($this->baseURL === null) {
            throw new BadMethodCallException('The $baseURL is not set.');
        }
        return $this->baseURL;
    }

    public function setBaseURL(string $baseURL): void
    {
        $this->baseURL = $baseURL;
    }

    public function setQueryArray(array $query)
    {
        $query = http_build_query($query);
        return $this->setQuery($query);
    }

    public function addQuery(string $key, $value = null)
    {
        $this->query[$key] = $value;
        return $this;
    }

    public function stripQuery(...$params)
    {
        foreach ($params as $param) {
            unset($this->query[$param]);
        }
        return $this;
    }

    public function keepQuery(...$params)
    {
        $temp = [];
        foreach ($this->query as $key => $value) {
            if (!in_array($key, $params, true)) {
                continue;
            }
            $temp[$key] = $value;
        }
        $this->query = $temp;
        return $this;
    }

    public function resolveRelativeURI(string $uri)
    {
        $relative = new self();
        $relative->setURI($uri);
        if ($relative->getScheme() === $this->getScheme()) {
            $relative->setScheme('');
        }
        $transformed = clone $relative;
        if (!empty($relative->getAuthority())) {
            $transformed->setAuthority($relative->getAuthority())->setPath($relative->getPath())->setQuery($relative->getQuery());
        } else {
            if ($relative->getPath() === '') {
                $transformed->setPath($this->getPath());
                if ($relative->getQuery()) {
                    $transformed->setQuery($relative->getQuery());
                } else {
                    $transformed->setQuery($this->getQuery());
                }
            } else {
                if (strpos($relative->getPath(), '/') === 0) {
                    $transformed->setPath($relative->getPath());
                } else {
                    $transformed->setPath($this->mergePaths($this, $relative));
                }
                $transformed->setQuery($relative->getQuery());
            }
            $transformed->setAuthority($this->getAuthority());
        }
        $transformed->setScheme($this->getScheme());
        $transformed->setFragment($relative->getFragment());
        return $transformed;
    }

    public function setAuthority(string $str)
    {
        $parts = parse_url($str);
        if (!isset($parts['path'])) {
            $parts['path'] = $this->getPath();
        }
        if (empty($parts['host']) && $parts['path'] !== '') {
            $parts['host'] = $parts['path'];
            unset($parts['path']);
        }
        $this->applyParts($parts);
        return $this;
    }

    protected function mergePaths(self $base, self $reference): string
    {
        if (!empty($base->getAuthority()) && $base->getPath() === '') {
            return '/' . ltrim($reference->getPath(), '/ ');
        }
        $path = explode('/', $base->getPath());
        if ($path[0] === '') {
            unset($path[0]);
        }
        array_pop($path);
        $path[] = $reference->getPath();
        return implode('/', $path);
    }

    protected function parseStr(string $query): array
    {
        $return = [];
        $query = explode('&', $query);
        $params = array_map(static fn(string $chunk) => preg_replace_callback('/^(?<key>[^&=]+?)(?:\[[^&=]*\])?=(?<value>[^&=]+)/', static fn(array $match) => str_replace($match['key'], bin2hex($match['key']), $match[0]), urldecode($chunk)), $query);
        $params = implode('&', $params);
        parse_str($params, $params);
        foreach ($params as $key => $value) {
            $return[hex2bin($key)] = $value;
        }
        $query = $params = null;
        return $return;
    }
}