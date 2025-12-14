<?php

namespace Higgs\Session\Handlers;

use Config\App as AppConfig;
use Config\Cookie as CookieConfig;
use Config\Session as SessionConfig;
use Psr\Log\LoggerAwareTrait;
use SessionHandlerInterface;

abstract class BaseHandler implements SessionHandlerInterface
{
    use LoggerAwareTrait;

    protected $fingerprint;
    protected $lock = false;
    protected $cookiePrefix = '';
    protected $cookieDomain = '';
    protected $cookiePath = '/';
    protected $cookieSecure = false;
    protected $cookieName;
    protected $matchIP = false;
    protected $sessionID;
    protected $savePath;
    protected $ipAddress;

    public function __construct(AppConfig $config, string $ipAddress)
    {
        $session = config('Session');
        if ($session instanceof SessionConfig) {
            $this->cookieName = $session->cookieName;
            $this->matchIP = $session->matchIP;
            $this->savePath = $session->savePath;
        } else {
            $this->cookieName = $config->sessionCookieName;
            $this->matchIP = $config->sessionMatchIP;
            $this->savePath = $config->sessionSavePath;
        }
        $cookie = config('Cookie');
        if ($cookie instanceof CookieConfig) {
            $this->cookieDomain = $cookie->domain;
            $this->cookiePath = $cookie->path;
            $this->cookieSecure = $cookie->secure;
        } else {
            $this->cookieDomain = $config->cookieDomain;
            $this->cookiePath = $config->cookiePath;
            $this->cookieSecure = $config->cookieSecure;
        }
        $this->ipAddress = $ipAddress;
    }

    protected function destroyCookie(): bool
    {
        return setcookie($this->cookieName, '', ['expires' => 1, 'path' => $this->cookiePath, 'domain' => $this->cookieDomain, 'secure' => $this->cookieSecure, 'httponly' => true]);
    }

    protected function lockSession(string $sessionID): bool
    {
        $this->lock = true;
        return true;
    }

    protected function releaseLock(): bool
    {
        $this->lock = false;
        return true;
    }

    protected function fail(): bool
    {
        ini_set('session.save_path', $this->savePath);
        return false;
    }
}