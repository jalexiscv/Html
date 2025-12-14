<?php

namespace Higgs\Security;

use Higgs\Cookie\Cookie;
use Higgs\HTTP\IncomingRequest;
use Higgs\HTTP\Request;
use Higgs\HTTP\RequestInterface;
use Higgs\I18n\Time;
use Higgs\Security\Exceptions\SecurityException;
use Higgs\Session\Session;
use Config\App;
use Config\Cookie as CookieConfig;
use Config\Security as SecurityConfig;
use Config\Services;
use ErrorException;
use InvalidArgumentException;
use LogicException;

class Security implements SecurityInterface
{
    public const CSRF_PROTECTION_COOKIE = 'cookie';
    public const CSRF_PROTECTION_SESSION = 'session';
    protected const CSRF_HASH_BYTES = 16;
    protected $csrfProtection = self::CSRF_PROTECTION_COOKIE;
    protected $tokenRandomize = false;
    protected $hash;
    protected $tokenName = 'csrf_token_name';
    protected $headerName = 'X-CSRF-TOKEN';
    protected $cookie;
    protected $cookieName = 'csrf_cookie_name';
    protected $expires = 7200;
    protected $regenerate = true;
    protected $redirect = false;
    protected $samesite = Cookie::SAMESITE_LAX;
    private IncomingRequest $request;
    private ?string $rawCookieName = null;
    private ?Session $session = null;
    private ?string $hashInCookie = null;

    public function __construct(App $config)
    {
        $security = config('Security');
        if ($security instanceof SecurityConfig) {
            $this->csrfProtection = $security->csrfProtection ?? $this->csrfProtection;
            $this->tokenName = $security->tokenName ?? $this->tokenName;
            $this->headerName = $security->headerName ?? $this->headerName;
            $this->regenerate = $security->regenerate ?? $this->regenerate;
            $this->redirect = $security->redirect ?? $this->redirect;
            $this->rawCookieName = $security->cookieName ?? $this->rawCookieName;
            $this->expires = $security->expires ?? $this->expires;
            $this->tokenRandomize = $security->tokenRandomize ?? $this->tokenRandomize;
        } else {
            $this->tokenName = $config->CSRFTokenName ?? $this->tokenName;
            $this->headerName = $config->CSRFHeaderName ?? $this->headerName;
            $this->regenerate = $config->CSRFRegenerate ?? $this->regenerate;
            $this->rawCookieName = $config->CSRFCookieName ?? $this->rawCookieName;
            $this->expires = $config->CSRFExpire ?? $this->expires;
            $this->redirect = $config->CSRFRedirect ?? $this->redirect;
        }
        if ($this->isCSRFCookie()) {
            $this->configureCookie($config);
        } else {
            $this->configureSession();
        }
        $this->request = Services::request();
        $this->hashInCookie = $this->request->getCookie($this->cookieName);
        $this->restoreHash();
        if ($this->hash === null) {
            $this->generateHash();
        }
    }

    private function isCSRFCookie(): bool
    {
        return $this->csrfProtection === self::CSRF_PROTECTION_COOKIE;
    }

    private function configureCookie(App $config): void
    {
        $cookie = config('Cookie');
        if ($cookie instanceof CookieConfig) {
            $cookiePrefix = $cookie->prefix;
            $this->cookieName = $cookiePrefix . $this->rawCookieName;
            Cookie::setDefaults($cookie);
        } else {
            $cookiePrefix = $config->cookiePrefix;
            $this->cookieName = $cookiePrefix . $this->rawCookieName;
        }
    }

    private function configureSession(): void
    {
        $this->session = Services::session();
    }

    private function restoreHash(): void
    {
        if ($this->isCSRFCookie()) {
            if ($this->isHashInCookie()) {
                $this->hash = $this->hashInCookie;
            }
        } elseif ($this->session->has($this->tokenName)) {
            $this->hash = $this->session->get($this->tokenName);
        }
    }

    private function isHashInCookie(): bool
    {
        if ($this->hashInCookie === null) {
            return false;
        }
        $length = static::CSRF_HASH_BYTES * 2;
        $pattern = '#^[0-9a-f]{' . $length . '}$#iS';
        return preg_match($pattern, $this->hashInCookie) === 1;
    }

    public function generateHash(): string
    {
        $this->hash = bin2hex(random_bytes(static::CSRF_HASH_BYTES));
        if ($this->isCSRFCookie()) {
            $this->saveHashInCookie();
        } else {
            $this->saveHashInSession();
        }
        return $this->hash;
    }

    private function saveHashInCookie(): void
    {
        $this->cookie = new Cookie($this->rawCookieName, $this->hash, ['expires' => $this->expires === 0 ? 0 : Time::now()->getTimestamp() + $this->expires,]);
        $response = Services::response();
        $response->setCookie($this->cookie);
    }

    private function saveHashInSession(): void
    {
        $this->session->set($this->tokenName, $this->hash);
    }

    public function CSRFVerify(RequestInterface $request)
    {
        return $this->verify($request);
    }

    public function verify(RequestInterface $request)
    {
        $method = strtoupper($request->getMethod());
        $methodsToProtect = ['POST', 'PUT', 'DELETE', 'PATCH'];
        if (!in_array($method, $methodsToProtect, true)) {
            return $this;
        }
        $postedToken = $this->getPostedToken($request);
        try {
            $token = ($postedToken !== null && $this->tokenRandomize) ? $this->derandomize($postedToken) : $postedToken;
        } catch (InvalidArgumentException $e) {
            $token = null;
        }
        if (!isset($token, $this->hash) || !hash_equals($this->hash, $token)) {
            throw SecurityException::forDisallowedAction();
        }
        $this->removeTokenInRequest($request);
        if ($this->regenerate) {
            $this->generateHash();
        }
        log_message('info', 'CSRF token verified.');
        return $this;
    }

    private function getPostedToken(RequestInterface $request): ?string
    {
        assert($request instanceof IncomingRequest);
        if ($request->hasHeader($this->headerName) && !empty($request->header($this->headerName)->getValue())) {
            $tokenName = $request->header($this->headerName)->getValue();
        } else {
            $body = (string)$request->getBody();
            $json = json_decode($body);
            if ($body !== '' && !empty($json) && json_last_error() === JSON_ERROR_NONE) {
                $tokenName = $json->{$this->tokenName} ?? null;
            } else {
                $tokenName = null;
            }
        }
        return $request->getPost($this->tokenName) ?? $tokenName;
    }

    protected function derandomize(string $token): string
    {
        $key = substr($token, -static::CSRF_HASH_BYTES * 2);
        $value = substr($token, 0, static::CSRF_HASH_BYTES * 2);
        try {
            return bin2hex(hex2bin($value) ^ hex2bin($key));
        } catch (ErrorException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    private function removeTokenInRequest(RequestInterface $request): void
    {
        assert($request instanceof Request);
        $json = json_decode($request->getBody() ?? '');
        if (isset($_POST[$this->tokenName])) {
            unset($_POST[$this->tokenName]);
            $request->setGlobal('post', $_POST);
        } elseif (isset($json->{$this->tokenName})) {
            unset($json->{$this->tokenName});
            $request->setBody(json_encode($json));
        }
    }

    public function getCSRFHash(): ?string
    {
        return $this->getHash();
    }

    public function getHash(): ?string
    {
        return $this->tokenRandomize ? $this->randomize($this->hash) : $this->hash;
    }

    protected function randomize(string $hash): string
    {
        $keyBinary = random_bytes(static::CSRF_HASH_BYTES);
        $hashBinary = hex2bin($hash);
        if ($hashBinary === false) {
            throw new LogicException('$hash is invalid: ' . $hash);
        }
        return bin2hex(($hashBinary ^ $keyBinary) . $keyBinary);
    }

    public function getCSRFTokenName(): string
    {
        return $this->getTokenName();
    }

    public function getTokenName(): string
    {
        return $this->tokenName;
    }

    public function getHeaderName(): string
    {
        return $this->headerName;
    }

    public function getCookieName(): string
    {
        return $this->cookieName;
    }

    public function isExpired(): bool
    {
        return $this->cookie->isExpired();
    }

    public function shouldRedirect(): bool
    {
        return $this->redirect;
    }

    public function sanitizeFilename(string $str, bool $relativePath = false): string
    {
        $bad = ['../', '<!--', '-->', '<', '>', "'", '"', '&', '$', '#', '{', '}', '[', ']', '=', ';', '?', '%20', '%22', '%3c', '%253c', '%3e', '%0e', '%28', '%29', '%2528', '%26', '%24', '%3f', '%3b', '%3d',];
        if (!$relativePath) {
            $bad[] = './';
            $bad[] = '/';
        }
        $str = remove_invisible_characters($str, false);
        do {
            $old = $str;
            $str = str_replace($bad, '', $str);
        } while ($old !== $str);
        return stripslashes($str);
    }

    protected function sendCookie(RequestInterface $request)
    {
        assert($request instanceof IncomingRequest);
        if ($this->cookie->isSecure() && !$request->isSecure()) {
            return false;
        }
        $this->doSendCookie();
        log_message('info', 'CSRF cookie sent.');
        return $this;
    }

    protected function doSendCookie(): void
    {
        cookies([$this->cookie], false)->dispatch();
    }
}