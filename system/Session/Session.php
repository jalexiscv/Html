<?php

namespace Higgs\Session;

use Higgs\Cookie\Cookie;
use Higgs\I18n\Time;
use Config\App;
use Config\Cookie as CookieConfig;
use Config\Services;
use Config\Session as SessionConfig;
use Psr\Log\LoggerAwareTrait;
use SessionHandlerInterface;

class Session implements SessionInterface
{
    use LoggerAwareTrait;

    protected $driver;
    protected $sessionDriverName;
    protected $sessionCookieName = 'ci_session';
    protected $sessionExpiration = 7200;
    protected $sessionSavePath;
    protected $sessionMatchIP = false;
    protected $sessionTimeToUpdate = 300;
    protected $sessionRegenerateDestroy = false;
    protected $cookie;
    protected $cookieDomain = '';
    protected $cookiePath = '/';
    protected $cookieSecure = false;
    protected $cookieSameSite = Cookie::SAMESITE_LAX;
    protected $sidRegexp;

    public function __construct(SessionHandlerInterface $driver, App $config)
    {
        $this->driver = $driver;
        $session = config('Session');
        if ($session instanceof SessionConfig) {
            $this->sessionDriverName = $session->driver;
            $this->sessionCookieName = $session->cookieName ?? $this->sessionCookieName;
            $this->sessionExpiration = $session->expiration ?? $this->sessionExpiration;
            $this->sessionSavePath = $session->savePath;
            $this->sessionMatchIP = $session->matchIP ?? $this->sessionMatchIP;
            $this->sessionTimeToUpdate = $session->timeToUpdate ?? $this->sessionTimeToUpdate;
            $this->sessionRegenerateDestroy = $session->regenerateDestroy ?? $this->sessionRegenerateDestroy;
        } else {
            $this->sessionDriverName = $config->sessionDriver;
            $this->sessionCookieName = $config->sessionCookieName ?? $this->sessionCookieName;
            $this->sessionExpiration = $config->sessionExpiration ?? $this->sessionExpiration;
            $this->sessionSavePath = $config->sessionSavePath;
            $this->sessionMatchIP = $config->sessionMatchIP ?? $this->sessionMatchIP;
            $this->sessionTimeToUpdate = $config->sessionTimeToUpdate ?? $this->sessionTimeToUpdate;
            $this->sessionRegenerateDestroy = $config->sessionRegenerateDestroy ?? $this->sessionRegenerateDestroy;
        }
        $this->cookiePath = $config->cookiePath ?? $this->cookiePath;
        $this->cookieDomain = $config->cookieDomain ?? $this->cookieDomain;
        $this->cookieSecure = $config->cookieSecure ?? $this->cookieSecure;
        $this->cookieSameSite = $config->cookieSameSite ?? $this->cookieSameSite;
        $cookie = config('Cookie');
        $this->cookie = (new Cookie($this->sessionCookieName, '', ['expires' => $this->sessionExpiration === 0 ? 0 : Time::now()->getTimestamp() + $this->sessionExpiration, 'path' => $cookie->path ?? $config->cookiePath, 'domain' => $cookie->domain ?? $config->cookieDomain, 'secure' => $cookie->secure ?? $config->cookieSecure, 'httponly' => true, 'samesite' => $cookie->samesite ?? $config->cookieSameSite ?? Cookie::SAMESITE_LAX, 'raw' => $cookie->raw ?? false,]))->withPrefix('');
        helper('array');
    }

    public function start()
    {
        if (is_cli() && ENVIRONMENT !== 'testing') {
            $this->logger->debug('Session: Initialization under CLI aborted.');
            return;
        }
        if ((bool)ini_get('session.auto_start')) {
            $this->logger->error('Session: session.auto_start is enabled in php.ini. Aborting.');
            return;
        }
        if (session_status() === PHP_SESSION_ACTIVE) {
            $this->logger->warning('Session: Sessions is enabled, and one exists.Please don\'t $session->start();');
            return;
        }
        $this->configure();
        $this->setSaveHandler();
        if (isset($_COOKIE[$this->sessionCookieName]) && (!is_string($_COOKIE[$this->sessionCookieName]) || !preg_match('#\A' . $this->sidRegexp . '\z#', $_COOKIE[$this->sessionCookieName]))) {
            unset($_COOKIE[$this->sessionCookieName]);
        }
        $this->startSession();
        if ((empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') && ($regenerateTime = $this->sessionTimeToUpdate) > 0) {
            if (!isset($_SESSION['__ci_last_regenerate'])) {
                $_SESSION['__ci_last_regenerate'] = Time::now()->getTimestamp();
            } elseif ($_SESSION['__ci_last_regenerate'] < (Time::now()->getTimestamp() - $regenerateTime)) {
                $this->regenerate((bool)$this->sessionRegenerateDestroy);
            }
        } elseif (isset($_COOKIE[$this->sessionCookieName]) && $_COOKIE[$this->sessionCookieName] === session_id()) {
            $this->setCookie();
        }
        $this->initVars();
        $this->logger->info("Session: Class initialized using '" . $this->sessionDriverName . "' driver.");
        return $this;
    }

    protected function configure()
    {
        if (empty($this->sessionCookieName)) {
            $this->sessionCookieName = ini_get('session.name');
        } else {
            ini_set('session.name', $this->sessionCookieName);
        }
        $sameSite = $this->cookie->getSameSite() ?: ucfirst(Cookie::SAMESITE_LAX);
        $params = ['lifetime' => $this->sessionExpiration, 'path' => $this->cookie->getPath(), 'domain' => $this->cookie->getDomain(), 'secure' => $this->cookie->isSecure(), 'httponly' => true, 'samesite' => $sameSite,];
        ini_set('session.cookie_samesite', $sameSite);
        session_set_cookie_params($params);
        if (!isset($this->sessionExpiration)) {
            $this->sessionExpiration = (int)ini_get('session.gc_maxlifetime');
        } elseif ($this->sessionExpiration > 0) {
            ini_set('session.gc_maxlifetime', (string)$this->sessionExpiration);
        }
        if (!empty($this->sessionSavePath)) {
            ini_set('session.save_path', $this->sessionSavePath);
        }
        ini_set('session.use_trans_sid', '0');
        ini_set('session.use_strict_mode', '1');
        ini_set('session.use_cookies', '1');
        ini_set('session.use_only_cookies', '1');
        $this->configureSidLength();
    }

    protected function configureSidLength()
    {
        $bitsPerCharacter = (int)(ini_get('session.sid_bits_per_character') !== false ? ini_get('session.sid_bits_per_character') : 4);
        $sidLength = (int)(ini_get('session.sid_length') !== false ? ini_get('session.sid_length') : 40);
        if (($sidLength * $bitsPerCharacter) < 160) {
            $bits = ($sidLength * $bitsPerCharacter);
            $sidLength += (int)ceil((160 % $bits) / $bitsPerCharacter);
            ini_set('session.sid_length', (string)$sidLength);
        }
        switch ($bitsPerCharacter) {
            case 4:
                $this->sidRegexp = '[0-9a-f]';
                break;
            case 5:
                $this->sidRegexp = '[0-9a-v]';
                break;
            case 6:
                $this->sidRegexp = '[0-9a-zA-Z,-]';
                break;
        }
        $this->sidRegexp .= '{' . $sidLength . '}';
    }

    protected function setSaveHandler()
    {
        session_set_save_handler($this->driver, true);
    }

    protected function startSession()
    {
        if (ENVIRONMENT === 'testing') {
            $_SESSION = [];
            return;
        }
        session_start();
    }

    public function regenerate(bool $destroy = false)
    {
        $_SESSION['__ci_last_regenerate'] = Time::now()->getTimestamp();
        session_regenerate_id($destroy);
        $this->removeOldSessionCookie();
    }

    private function removeOldSessionCookie(): void
    {
        $response = Services::response();
        $cookieStoreInResponse = $response->getCookieStore();
        if (!$cookieStoreInResponse->has($this->sessionCookieName)) {
            return;
        }
        $newCookieStore = $cookieStoreInResponse->remove($this->sessionCookieName);
        $cookieStoreInResponse->clear();
        foreach ($newCookieStore as $cookie) {
            $response->setCookie($cookie);
        }
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove($key)
    {
        if (is_array($key)) {
            foreach ($key as $k) {
                unset($_SESSION[$k]);
            }
            return;
        }
        unset($_SESSION[$key]);
    }

    protected function setCookie()
    {
        $expiration = $this->sessionExpiration === 0 ? 0 : Time::now()->getTimestamp() + $this->sessionExpiration;
        $this->cookie = $this->cookie->withValue(session_id())->withExpires($expiration);
        $response = Services::response();
        $response->setCookie($this->cookie);
    }

    protected function initVars()
    {
        if (empty($_SESSION['__ci_vars'])) {
            return;
        }
        $currentTime = Time::now()->getTimestamp();
        foreach ($_SESSION['__ci_vars'] as $key => &$value) {
            if ($value === 'new') {
                $_SESSION['__ci_vars'][$key] = 'old';
            } elseif ($value === 'old' || $value < $currentTime) {
                unset($_SESSION[$key], $_SESSION['__ci_vars'][$key]);
            }
        }
        if (empty($_SESSION['__ci_vars'])) {
            unset($_SESSION['__ci_vars']);
        }
    }

    public function stop()
    {
        setcookie($this->sessionCookieName, session_id(), ['expires' => 1, 'path' => $this->cookie->getPath(), 'domain' => $this->cookie->getDomain(), 'secure' => $this->cookie->isSecure(), 'httponly' => true]);
        session_regenerate_id(true);
    }

    public function destroy()
    {
        if (ENVIRONMENT === 'testing') {
            return;
        }
        session_destroy();
    }

    public function push(string $key, array $data)
    {
        if ($this->has($key) && is_array($value = $this->get($key))) {
            $this->set($key, array_merge($value, $data));
        }
    }

    public function get(?string $key = null)
    {
        if (!empty($key) && (null !== ($value = $_SESSION[$key] ?? null) || null !== ($value = dot_array_search($key, $_SESSION ?? [])))) {
            return $value;
        }
        if (empty($_SESSION)) {
            return $key === null ? [] : null;
        }
        if (!empty($key)) {
            return null;
        }
        $userdata = [];
        $_exclude = array_merge(['__ci_vars'], $this->getFlashKeys(), $this->getTempKeys());
        $keys = array_keys($_SESSION);
        foreach ($keys as $key) {
            if (!in_array($key, $_exclude, true)) {
                $userdata[$key] = $_SESSION[$key];
            }
        }
        return $userdata;
    }

    public function getFlashKeys(): array
    {
        if (!isset($_SESSION['__ci_vars'])) {
            return [];
        }
        $keys = [];
        foreach (array_keys($_SESSION['__ci_vars']) as $key) {
            if (!is_int($_SESSION['__ci_vars'][$key])) {
                $keys[] = $key;
            }
        }
        return $keys;
    }

    public function getTempKeys(): array
    {
        if (!isset($_SESSION['__ci_vars'])) {
            return [];
        }
        $keys = [];
        foreach (array_keys($_SESSION['__ci_vars']) as $key) {
            if (is_int($_SESSION['__ci_vars'][$key])) {
                $keys[] = $key;
            }
        }
        return $keys;
    }

    public function set($data, $value = null)
    {
        if (is_array($data)) {
            foreach ($data as $key => &$value) {
                if (is_int($key)) {
                    $_SESSION[$value] = null;
                } else {
                    $_SESSION[$key] = $value;
                }
            }
            return;
        }
        $_SESSION[$data] = $value;
    }

    public function __get(string $key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        if ($key === 'session_id') {
            return session_id();
        }
        return null;
    }

    public function __set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function __isset(string $key): bool
    {
        return isset($_SESSION[$key]) || ($key === 'session_id');
    }

    public function setFlashdata($data, $value = null)
    {
        $this->set($data, $value);
        $this->markAsFlashdata(is_array($data) ? array_keys($data) : $data);
    }

    public function markAsFlashdata($key): bool
    {
        if (is_array($key)) {
            foreach ($key as $sessionKey) {
                if (!isset($_SESSION[$sessionKey])) {
                    return false;
                }
            }
            $new = array_fill_keys($key, 'new');
            $_SESSION['__ci_vars'] = isset($_SESSION['__ci_vars']) ? array_merge($_SESSION['__ci_vars'], $new) : $new;
            return true;
        }
        if (!isset($_SESSION[$key])) {
            return false;
        }
        $_SESSION['__ci_vars'][$key] = 'new';
        return true;
    }

    public function getFlashdata(?string $key = null)
    {
        if (isset($key)) {
            return (isset($_SESSION['__ci_vars'], $_SESSION['__ci_vars'][$key], $_SESSION[$key]) && !is_int($_SESSION['__ci_vars'][$key])) ? $_SESSION[$key] : null;
        }
        $flashdata = [];
        if (!empty($_SESSION['__ci_vars'])) {
            foreach ($_SESSION['__ci_vars'] as $key => &$value) {
                if (!is_int($value)) {
                    $flashdata[$key] = $_SESSION[$key];
                }
            }
        }
        return $flashdata;
    }

    public function keepFlashdata($key)
    {
        $this->markAsFlashdata($key);
    }

    public function unmarkFlashdata($key)
    {
        if (empty($_SESSION['__ci_vars'])) {
            return;
        }
        if (!is_array($key)) {
            $key = [$key];
        }
        foreach ($key as $k) {
            if (isset($_SESSION['__ci_vars'][$k]) && !is_int($_SESSION['__ci_vars'][$k])) {
                unset($_SESSION['__ci_vars'][$k]);
            }
        }
        if (empty($_SESSION['__ci_vars'])) {
            unset($_SESSION['__ci_vars']);
        }
    }

    public function setTempdata($data, $value = null, int $ttl = 300)
    {
        $this->set($data, $value);
        $this->markAsTempdata($data, $ttl);
    }

    public function markAsTempdata($key, int $ttl = 300): bool
    {
        $ttl += Time::now()->getTimestamp();
        if (is_array($key)) {
            $temp = [];
            foreach ($key as $k => $v) {
                if (is_int($k)) {
                    $k = $v;
                    $v = $ttl;
                } elseif (is_string($v)) {
                    $v = Time::now()->getTimestamp() + $ttl;
                } else {
                    $v += Time::now()->getTimestamp();
                }
                if (!array_key_exists($k, $_SESSION)) {
                    return false;
                }
                $temp[$k] = $v;
            }
            $_SESSION['__ci_vars'] = isset($_SESSION['__ci_vars']) ? array_merge($_SESSION['__ci_vars'], $temp) : $temp;
            return true;
        }
        if (!isset($_SESSION[$key])) {
            return false;
        }
        $_SESSION['__ci_vars'][$key] = $ttl;
        return true;
    }

    public function getTempdata(?string $key = null)
    {
        if (isset($key)) {
            return (isset($_SESSION['__ci_vars'], $_SESSION['__ci_vars'][$key], $_SESSION[$key]) && is_int($_SESSION['__ci_vars'][$key])) ? $_SESSION[$key] : null;
        }
        $tempdata = [];
        if (!empty($_SESSION['__ci_vars'])) {
            foreach ($_SESSION['__ci_vars'] as $key => &$value) {
                if (is_int($value)) {
                    $tempdata[$key] = $_SESSION[$key];
                }
            }
        }
        return $tempdata;
    }

    public function removeTempdata(string $key)
    {
        $this->unmarkTempdata($key);
        unset($_SESSION[$key]);
    }

    public function unmarkTempdata($key)
    {
        if (empty($_SESSION['__ci_vars'])) {
            return;
        }
        if (!is_array($key)) {
            $key = [$key];
        }
        foreach ($key as $k) {
            if (isset($_SESSION['__ci_vars'][$k]) && is_int($_SESSION['__ci_vars'][$k])) {
                unset($_SESSION['__ci_vars'][$k]);
            }
        }
        if (empty($_SESSION['__ci_vars'])) {
            unset($_SESSION['__ci_vars']);
        }
    }
}