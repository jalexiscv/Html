<?php

namespace Higgs\HTTP;

use Higgs\Cookie\Cookie;
use Higgs\Cookie\CookieStore;
use Higgs\Cookie\Exceptions\CookieException;
use Higgs\HTTP\Exceptions\HTTPException;
use Higgs\I18n\Time;
use Higgs\Pager\PagerInterface;
use Higgs\Security\Exceptions\SecurityException;
use Config\Cookie as CookieConfig;
use Config\Services;
use DateTime;
use DateTimeZone;
use InvalidArgumentException;

trait ResponseTrait
{
    public $CSP;
    protected $CSPEnabled = false;
    protected $cookieStore;
    protected $cookiePrefix = '';
    protected $cookieDomain = '';
    protected $cookiePath = '/';
    protected $cookieSecure = false;
    protected $cookieHTTPOnly = false;
    protected $cookieSameSite = Cookie::SAMESITE_LAX;
    protected $cookies = [];
    protected $bodyFormat = 'html';

    public function setLink(PagerInterface $pager)
    {
        $links = '';
        if ($previous = $pager->getPreviousPageURI()) {
            $links .= '<' . $pager->getPageURI($pager->getFirstPage()) . '>; rel="first",';
            $links .= '<' . $previous . '>; rel="prev"';
        }
        if (($next = $pager->getNextPageURI()) && $previous) {
            $links .= ',';
        }
        if ($next) {
            $links .= '<' . $next . '>; rel="next",';
            $links .= '<' . $pager->getPageURI($pager->getLastPage()) . '>; rel="last"';
        }
        $this->setHeader('Link', $links);
        return $this;
    }

    public function setJSON($body, bool $unencoded = false)
    {
        $this->body = $this->formatBody($body, 'json' . ($unencoded ? '-unencoded' : ''));
        return $this;
    }

    protected function formatBody($body, string $format)
    {
        $this->bodyFormat = ($format === 'json-unencoded' ? 'json' : $format);
        $mime = "application/{$this->bodyFormat}";
        $this->setContentType($mime);
        if (!is_string($body) || $format === 'json-unencoded') {
            $body = Services::format()->getFormatter($mime)->format($body);
        }
        return $body;
    }

    public function setContentType(string $mime, string $charset = 'UTF-8')
    {
        if ((strpos($mime, 'charset=') < 1) && !empty($charset)) {
            $mime .= '; charset=' . $charset;
        }
        $this->removeHeader('Content-Type');
        $this->setHeader('Content-Type', $mime);
        return $this;
    }

    public function getJSON()
    {
        $body = $this->body;
        if ($this->bodyFormat !== 'json') {
            $body = Services::format()->getFormatter('application/json')->format($body);
        }
        return $body ?: null;
    }

    public function setXML($body)
    {
        $this->body = $this->formatBody($body, 'xml');
        return $this;
    }

    public function getXML()
    {
        $body = $this->body;
        if ($this->bodyFormat !== 'xml') {
            $body = Services::format()->getFormatter('application/xml')->format($body);
        }
        return $body;
    }

    public function noCache()
    {
        $this->removeHeader('Cache-control');
        $this->setHeader('Cache-control', ['no-store', 'max-age=0', 'no-cache']);
        return $this;
    }

    public function setCache(array $options = [])
    {
        if (empty($options)) {
            return $this;
        }
        $this->removeHeader('Cache-Control');
        $this->removeHeader('ETag');
        if (isset($options['etag'])) {
            $this->setHeader('ETag', $options['etag']);
            unset($options['etag']);
        }
        if (isset($options['last-modified'])) {
            $this->setLastModified($options['last-modified']);
            unset($options['last-modified']);
        }
        $this->setHeader('Cache-control', $options);
        return $this;
    }

    public function setLastModified($date)
    {
        if ($date instanceof DateTime) {
            $date->setTimezone(new DateTimeZone('UTC'));
            $this->setHeader('Last-Modified', $date->format('D, d M Y H:i:s') . ' GMT');
        } elseif (is_string($date)) {
            $this->setHeader('Last-Modified', $date);
        }
        return $this;
    }

    public function send()
    {
        if ($this->CSP->enabled()) {
            $this->CSP->finalize($this);
        } else {
            $this->body = str_replace(['{csp-style-nonce}', '{csp-script-nonce}'], '', $this->body ?? '');
        }
        $this->sendHeaders();
        $this->sendCookies();
        $this->sendBody();
        return $this;
    }

    public function sendHeaders()
    {
        if ($this->pretend || headers_sent()) {
            return $this;
        }
        if (!isset($this->headers['Date']) && PHP_SAPI !== 'cli-server') {
            $this->setDate(DateTime::createFromFormat('U', (string)Time::now()->getTimestamp()));
        }
        header(sprintf('HTTP/%s %s %s', $this->getProtocolVersion(), $this->getStatusCode(), $this->getReasonPhrase()), true, $this->getStatusCode());
        foreach (array_keys($this->headers()) as $name) {
            header($name . ': ' . $this->getHeaderLine($name), false, $this->getStatusCode());
        }
        return $this;
    }

    public function setDate(DateTime $date)
    {
        $date->setTimezone(new DateTimeZone('UTC'));
        $this->setHeader('Date', $date->format('D, d M Y H:i:s') . ' GMT');
        return $this;
    }

    protected function sendCookies()
    {
        if ($this->pretend) {
            return;
        }
        $this->dispatchCookies();
    }

    private function dispatchCookies(): void
    {
        $request = Services::request();
        foreach ($this->cookieStore->display() as $cookie) {
            if ($cookie->isSecure() && !$request->isSecure()) {
                throw SecurityException::forDisallowedAction();
            }
            $name = $cookie->getPrefixedName();
            $value = $cookie->getValue();
            $options = $cookie->getOptions();
            if ($cookie->isRaw()) {
                $this->doSetRawCookie($name, $value, $options);
            } else {
                $this->doSetCookie($name, $value, $options);
            }
        }
        $this->cookieStore->clear();
    }

    private function doSetRawCookie(string $name, string $value, array $options): void
    {
        setrawcookie($name, $value, $options);
    }

    private function doSetCookie(string $name, string $value, array $options): void
    {
        setcookie($name, $value, $options);
    }

    public function sendBody()
    {
        echo $this->body;
        return $this;
    }

    public function redirect(string $uri, string $method = 'auto', ?int $code = null)
    {
        if (empty($code)) {
            $code = 302;
        }
        if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== false) {
            $method = 'refresh';
        }
        if (isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['REQUEST_METHOD']) && $this->getProtocolVersion() >= 1.1 && $method !== 'refresh') {
            $code = ($_SERVER['REQUEST_METHOD'] !== 'GET') ? 303 : ($code === 302 ? 307 : $code);
        }
        switch ($method) {
            case 'refresh':
                $this->setHeader('Refresh', '0;url=' . $uri);
                break;
            default:
                $this->setHeader('Location', $uri);
                break;
        }
        $this->setStatusCode($code);
        return $this;
    }

    public function setStatusCode(int $code, string $reason = '')
    {
        if ($code < 100 || $code > 599) {
            throw HTTPException::forInvalidStatusCode($code);
        }
        if (!array_key_exists($code, static::$statusCodes) && empty($reason)) {
            throw HTTPException::forUnkownStatusCode($code);
        }
        $this->statusCode = $code;
        $this->reason = !empty($reason) ? $reason : static::$statusCodes[$code];
        return $this;
    }

    public function getCookieStore()
    {
        return $this->cookieStore;
    }

    public function hasCookie(string $name, ?string $value = null, string $prefix = ''): bool
    {
        $prefix = $prefix ?: Cookie::setDefaults()['prefix'];
        return $this->cookieStore->has($name, $prefix, $value);
    }

    public function getCookie(?string $name = null, string $prefix = '')
    {
        if ((string)$name === '') {
            return $this->cookieStore->display();
        }
        try {
            $prefix = $prefix ?: Cookie::setDefaults()['prefix'];
            return $this->cookieStore->get($name, $prefix);
        } catch (CookieException $e) {
            log_message('error', (string)$e);
            return null;
        }
    }

    public function deleteCookie(string $name = '', string $domain = '', string $path = '/', string $prefix = '')
    {
        if ($name === '') {
            return $this;
        }
        $prefix = $prefix ?: Cookie::setDefaults()['prefix'];
        $prefixed = $prefix . $name;
        $store = $this->cookieStore;
        $found = false;
        foreach ($store as $cookie) {
            if ($cookie->getPrefixedName() === $prefixed) {
                if ($domain !== $cookie->getDomain()) {
                    continue;
                }
                if ($path !== $cookie->getPath()) {
                    continue;
                }
                $cookie = $cookie->withValue('')->withExpired();
                $found = true;
                $this->cookieStore = $store->put($cookie);
                break;
            }
        }
        if (!$found) {
            $this->setCookie($name, '', '', $domain, $path, $prefix);
        }
        return $this;
    }

    public function setCookie($name, $value = '', $expire = '', $domain = '', $path = '/', $prefix = '', $secure = null, $httponly = null, $samesite = null)
    {
        if ($name instanceof Cookie) {
            $this->cookieStore = $this->cookieStore->put($name);
            return $this;
        }
        $cookieConfig = config('Cookie');
        if ($cookieConfig instanceof CookieConfig) {
            $secure ??= $cookieConfig->secure;
            $httponly ??= $cookieConfig->httponly;
            $samesite ??= $cookieConfig->samesite;
        }
        if (is_array($name)) {
            foreach (['samesite', 'value', 'expire', 'domain', 'path', 'prefix', 'secure', 'httponly', 'name'] as $item) {
                if (isset($name[$item])) {
                    ${$item} = $name[$item];
                }
            }
        }
        if (is_numeric($expire)) {
            $expire = $expire > 0 ? Time::now()->getTimestamp() + $expire : 0;
        }
        $cookie = new Cookie($name, $value, ['expires' => $expire ?: 0, 'domain' => $domain, 'path' => $path, 'prefix' => $prefix, 'secure' => $secure, 'httponly' => $httponly, 'samesite' => $samesite ?? '',]);
        $this->cookieStore = $this->cookieStore->put($cookie);
        return $this;
    }

    public function getCookies()
    {
        return $this->cookieStore->display();
    }

    public function download(string $filename = '', $data = '', bool $setMime = false)
    {
        if ($filename === '' || $data === '') {
            return null;
        }
        $filepath = '';
        if ($data === null) {
            $filepath = $filename;
            $filename = explode('/', str_replace(DIRECTORY_SEPARATOR, '/', $filename));
            $filename = end($filename);
        }
        $response = new DownloadResponse($filename, $setMime);
        if ($filepath !== '') {
            $response->setFilePath($filepath);
        } elseif ($data !== null) {
            $response->setBinary($data);
        }
        return $response;
    }

    public function getCSP(): ContentSecurityPolicy
    {
        return $this->CSP;
    }
}