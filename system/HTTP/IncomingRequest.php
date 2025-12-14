<?php

namespace Higgs\HTTP;

use Higgs\HTTP\Exceptions\HTTPException;
use Higgs\HTTP\Files\FileCollection;
use Higgs\HTTP\Files\UploadedFile;
use Config\App;
use Config\Services;
use InvalidArgumentException;
use Locale;
use stdClass;

class IncomingRequest extends Request
{
    public $uri;
    public $config;
    protected $enableCSRF = false;
    protected $path;
    protected $files;
    protected $negotiator;
    protected $defaultLocale;
    protected $locale;
    protected $validLocales = [];
    protected $oldInput = [];
    protected $userAgent;

    public function __construct($config, ?URI $uri = null, $body = 'php://input', ?UserAgent $userAgent = null)
    {
        if (empty($uri) || empty($userAgent)) {
            throw new InvalidArgumentException('You must supply the parameters: uri, userAgent.');
        }
        $this->populateHeaders();
        if ($body === 'php://input' && strpos($this->getHeaderLine('Content-Type'), 'multipart/form-data') === false && (int)$this->getHeaderLine('Content-Length') <= $this->getPostMaxSize()) {
            $body = file_get_contents('php://input');
        }
        $this->config = $config;
        $this->uri = $uri;
        $this->body = !empty($body) ? $body : null;
        $this->userAgent = $userAgent;
        $this->validLocales = $config->supportedLocales;
        parent::__construct($config);
        $this->detectURI($config->uriProtocol, $config->baseURL);
        $this->detectLocale($config);
    }

    private function getPostMaxSize(): int
    {
        $postMaxSize = ini_get('post_max_size');
        switch (strtoupper(substr($postMaxSize, -1))) {
            case 'G':
                $postMaxSize = (int)str_replace('G', '', $postMaxSize) * 1024 ** 3;
                break;
            case 'M':
                $postMaxSize = (int)str_replace('M', '', $postMaxSize) * 1024 ** 2;
                break;
            case 'K':
                $postMaxSize = (int)str_replace('K', '', $postMaxSize) * 1024;
                break;
            default:
                $postMaxSize = (int)$postMaxSize;
        }
        return $postMaxSize;
    }

    protected function detectURI(string $protocol, string $baseURL)
    {
        $this->setPath($this->detectPath($this->config->uriProtocol), $this->config);
    }

    public function detectPath(string $protocol = ''): string
    {
        if (empty($protocol)) {
            $protocol = 'REQUEST_URI';
        }
        switch ($protocol) {
            case 'REQUEST_URI':
                $this->path = $this->parseRequestURI();
                break;
            case 'QUERY_STRING':
                $this->path = $this->parseQueryString();
                break;
            case 'PATH_INFO':
            default:
                $this->path = $this->fetchGlobal('server', $protocol) ?? $this->parseRequestURI();
                break;
        }
        return $this->path;
    }

    protected function parseRequestURI(): string
    {
        if (!isset($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME'])) {
            return '';
        }
        $parts = parse_url('http://dummy' . $_SERVER['REQUEST_URI']);
        $query = $parts['query'] ?? '';
        $uri = $parts['path'] ?? '';
        if ($uri !== '' && isset($_SERVER['SCRIPT_NAME'][0]) && pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_EXTENSION) === 'php') {
            $segments = $keep = explode('/', $uri);
            foreach (explode('/', $_SERVER['SCRIPT_NAME']) as $i => $segment) {
                if (!isset($segments[$i]) || $segment !== $segments[$i]) {
                    break;
                }
                array_shift($keep);
            }
            $uri = implode('/', $keep);
        }
        if (trim($uri, '/') === '' && strncmp($query, '/', 1) === 0) {
            $query = explode('?', $query, 2);
            $uri = $query[0];
            $_SERVER['QUERY_STRING'] = $query[1] ?? '';
        } else {
            $_SERVER['QUERY_STRING'] = $query;
        }
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $this->populateGlobals('server');
        $this->populateGlobals('get');
        $uri = URI::removeDotSegments($uri);
        return ($uri === '/' || $uri === '') ? '/' : ltrim($uri, '/');
    }

    protected function parseQueryString(): string
    {
        $uri = $_SERVER['QUERY_STRING'] ?? @getenv('QUERY_STRING');
        if (trim($uri, '/') === '') {
            return '';
        }
        if (strncmp($uri, '/', 1) === 0) {
            $uri = explode('?', $uri, 2);
            $_SERVER['QUERY_STRING'] = $uri[1] ?? '';
            $uri = $uri[0];
        }
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $this->populateGlobals('server');
        $this->populateGlobals('get');
        $uri = URI::removeDotSegments($uri);
        return ($uri === '/' || $uri === '') ? '/' : ltrim($uri, '/');
    }

    public function detectLocale($config)
    {
        $this->locale = $this->defaultLocale = $config->defaultLocale;
        if (!$config->negotiateLocale) {
            return;
        }
        $this->setLocale($this->negotiate('language', $config->supportedLocales));
    }

    public function negotiate(string $type, array $supported, bool $strictMatch = false): string
    {
        if ($this->negotiator === null) {
            $this->negotiator = Services::negotiator($this, true);
        }
        switch (strtolower($type)) {
            case 'media':
                return $this->negotiator->media($supported, $strictMatch);
            case 'charset':
                return $this->negotiator->charset($supported);
            case 'encoding':
                return $this->negotiator->encoding($supported);
            case 'language':
                return $this->negotiator->language($supported);
        }
        throw HTTPException::forInvalidNegotiationType($type);
    }

    public function is(string $type): bool
    {
        $valueUpper = strtoupper($type);
        $httpMethods = ['GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'PATCH', 'OPTIONS'];
        if (in_array($valueUpper, $httpMethods, true)) {
            return strtoupper($this->getMethod()) === $valueUpper;
        }
        if ($valueUpper === 'JSON') {
            return strpos($this->getHeaderLine('Content-Type'), 'application/json') !== false;
        }
        if ($valueUpper === 'AJAX') {
            return $this->isAJAX();
        }
        throw new InvalidArgumentException('Unknown type: ' . $type);
    }

    public function isAJAX(): bool
    {
        return $this->hasHeader('X-Requested-With') && strtolower($this->header('X-Requested-With')->getValue()) === 'xmlhttprequest';
    }

    public function isCLI(): bool
    {
        return false;
    }

    public function isSecure(): bool
    {
        if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
            return true;
        }
        if ($this->hasHeader('X-Forwarded-Proto') && $this->header('X-Forwarded-Proto')->getValue() === 'https') {
            return true;
        }
        return $this->hasHeader('Front-End-Https') && !empty($this->header('Front-End-Https')->getValue()) && strtolower($this->header('Front-End-Https')->getValue()) !== 'off';
    }

    public function getPath(): string
    {
        if ($this->path === null) {
            $this->detectPath($this->config->uriProtocol);
        }
        return $this->path;
    }

    public function setPath(string $path, ?App $config = null)
    {
        $this->path = $path;
        $this->uri->setPath($path);
        $config ??= $this->config;
        $baseURL = ($config->baseURL === '') ? $config->baseURL : rtrim($config->baseURL, '/ ') . '/';
        if ($baseURL !== '') {
            $host = $this->determineHost($config, $baseURL);
            $uri = new URI($baseURL);
            $currentBaseURL = (string)$uri->setHost($host);
            $this->uri->setBaseURL($currentBaseURL);
            $this->uri->setScheme(parse_url($baseURL, PHP_URL_SCHEME));
            $this->uri->setHost($host);
            $this->uri->setPort(parse_url($baseURL, PHP_URL_PORT));
            $this->uri->setQuery($_SERVER['QUERY_STRING'] ?? '');
            if ($config->forceGlobalSecureRequests && $this->uri->getScheme() === 'http') {
                $this->uri->setScheme('https');
            }
        } elseif (!is_cli()) {
            exit('You have an empty or invalid base URL. The baseURL value must be set in Config\App.php, or through the .env file.');
        }
        return $this;
    }

    public function getLocale(): string
    {
        return $this->locale ?? $this->defaultLocale;
    }

    public function setLocale(string $locale)
    {
        if (!in_array($locale, $this->validLocales, true)) {
            $locale = $this->defaultLocale;
        }
        $this->locale = $locale;
        Locale::setDefault($locale);
        return $this;
    }

    public function getDefaultLocale(): string
    {
        return $this->defaultLocale;
    }

    public function getVar($index = null, $filter = null, $flags = null)
    {
        if (strpos($this->getHeaderLine('Content-Type'), 'application/json') !== false && $this->body !== null) {
            return $this->getJsonVar($index, false, $filter, $flags);
        }
        return $this->fetchGlobal('request', $index, $filter, $flags);
    }

    public function getJsonVar($index = null, bool $assoc = false, ?int $filter = null, $flags = null)
    {
        helper('array');
        $data = $this->getJSON(true);
        if (!is_array($data)) {
            return null;
        }
        if (is_string($index)) {
            $data = dot_array_search($index, $data);
        } elseif (is_array($index)) {
            $result = [];
            foreach ($index as $key) {
                $result[$key] = dot_array_search($key, $data);
            }
            [$data, $result] = [$result, null];
        }
        if ($data === null) {
            return null;
        }
        $filter ??= FILTER_DEFAULT;
        $flags = is_array($flags) ? $flags : (is_numeric($flags) ? (int)$flags : 0);
        if ($filter !== FILTER_DEFAULT || ((is_numeric($flags) && $flags !== 0) || is_array($flags) && $flags !== [])) {
            if (is_array($data)) {
                array_walk_recursive($data, static function (&$val) use ($filter, $flags) {
                    $valType = gettype($val);
                    $val = filter_var($val, $filter, $flags);
                    if (in_array($valType, ['int', 'integer', 'float', 'double', 'bool', 'boolean'], true) && $val !== false) {
                        settype($val, $valType);
                    }
                });
            } else {
                $dataType = gettype($data);
                $data = filter_var($data, $filter, $flags);
                if (in_array($dataType, ['int', 'integer', 'float', 'double', 'bool', 'boolean'], true) && $data !== false) {
                    settype($data, $dataType);
                }
            }
        }
        if (!$assoc) {
            if (is_array($index)) {
                foreach ($data as &$val) {
                    $val = is_array($val) ? json_decode(json_encode($val)) : $val;
                }
                return $data;
            }
            return json_decode(json_encode($data));
        }
        return $data;
    }

    public function getJSON(bool $assoc = false, int $depth = 512, int $options = 0)
    {
        return json_decode($this->body ?? '', $assoc, $depth, $options);
    }

    public function getRawInput()
    {
        parse_str($this->body ?? '', $output);
        return $output;
    }

    public function getRawInputVar($index = null, ?int $filter = null, $flags = null)
    {
        helper('array');
        parse_str($this->body ?? '', $output);
        if (is_string($index)) {
            $output = dot_array_search($index, $output);
        } elseif (is_array($index)) {
            $data = [];
            foreach ($index as $key) {
                $data[$key] = dot_array_search($key, $output);
            }
            [$output, $data] = [$data, null];
        }
        $filter ??= FILTER_DEFAULT;
        $flags = is_array($flags) ? $flags : (is_numeric($flags) ? (int)$flags : 0);
        if (is_array($output) && ($filter !== FILTER_DEFAULT || ((is_numeric($flags) && $flags !== 0) || is_array($flags) && $flags !== []))) {
            array_walk_recursive($output, static function (&$val) use ($filter, $flags) {
                $val = filter_var($val, $filter, $flags);
            });
            return $output;
        }
        if (is_string($output)) {
            return filter_var($output, $filter, $flags);
        }
        return $output;
    }

    public function getPostGet($index = null, $filter = null, $flags = null)
    {
        if ($index === null) {
            return array_merge($this->getGet($index, $filter, $flags), $this->getPost($index, $filter, $flags));
        }
        return isset($_POST[$index]) ? $this->getPost($index, $filter, $flags) : (isset($_GET[$index]) ? $this->getGet($index, $filter, $flags) : $this->getPost($index, $filter, $flags));
    }

    public function getGet($index = null, $filter = null, $flags = null)
    {
        return $this->fetchGlobal('get', $index, $filter, $flags);
    }

    public function getPost($index = null, $filter = null, $flags = null)
    {
        return $this->fetchGlobal('post', $index, $filter, $flags);
    }

    public function getGetPost($index = null, $filter = null, $flags = null)
    {
        if ($index === null) {
            return array_merge($this->getPost($index, $filter, $flags), $this->getGet($index, $filter, $flags));
        }
        return isset($_GET[$index]) ? $this->getGet($index, $filter, $flags) : (isset($_POST[$index]) ? $this->getPost($index, $filter, $flags) : $this->getGet($index, $filter, $flags));
    }

    public function getCookie($index = null, $filter = null, $flags = null)
    {
        return $this->fetchGlobal('cookie', $index, $filter, $flags);
    }

    public function getUserAgent()
    {
        return $this->userAgent;
    }

    public function getOldInput(string $key)
    {
        if (empty($_SESSION['_ci_old_input'])) {
            return null;
        }
        if (isset($_SESSION['_ci_old_input']['post'][$key])) {
            return $_SESSION['_ci_old_input']['post'][$key];
        }
        if (isset($_SESSION['_ci_old_input']['get'][$key])) {
            return $_SESSION['_ci_old_input']['get'][$key];
        }
        helper('array');
        if (isset($_SESSION['_ci_old_input']['post'])) {
            $value = dot_array_search($key, $_SESSION['_ci_old_input']['post']);
            if ($value !== null) {
                return $value;
            }
        }
        if (isset($_SESSION['_ci_old_input']['get'])) {
            $value = dot_array_search($key, $_SESSION['_ci_old_input']['get']);
            if ($value !== null) {
                return $value;
            }
        }
        return null;
    }

    public function getFiles(): array
    {
        if ($this->files === null) {
            $this->files = new FileCollection();
        }
        return $this->files->all();
    }

    public function getFileMultiple(string $fileID)
    {
        if ($this->files === null) {
            $this->files = new FileCollection();
        }
        return $this->files->getFileMultiple($fileID);
    }

    public function getFile(string $fileID)
    {
        if ($this->files === null) {
            $this->files = new FileCollection();
        }
        return $this->files->getFile($fileID);
    }

    protected function removeRelativeDirectory(string $uri): string
    {
        $uri = URI::removeDotSegments($uri);
        return $uri === '/' ? $uri : ltrim($uri, '/');
    }

    private function determineHost(App $config, string $baseURL): string
    {
        $host = parse_url($baseURL, PHP_URL_HOST);
        if (empty($config->allowedHostnames)) {
            return $host;
        }
        $httpHostPort = $this->getServer('HTTP_HOST');
        if ($httpHostPort !== null) {
            [$httpHost] = explode(':', $httpHostPort, 2);
            if (in_array($httpHost, $config->allowedHostnames, true)) {
                $host = $httpHost;
            }
        }
        return $host;
    }
}