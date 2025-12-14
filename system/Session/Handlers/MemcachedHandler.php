<?php

namespace Higgs\Session\Handlers;

use Higgs\I18n\Time;
use Higgs\Session\Exceptions\SessionException;
use Config\App as AppConfig;
use Config\Session as SessionConfig;
use Memcached;
use ReturnTypeWillChange;

class MemcachedHandler extends BaseHandler
{
    protected $memcached;
    protected $keyPrefix = 'ci_session:';
    protected $lockKey;
    protected $sessionExpiration = 7200;

    public function __construct(AppConfig $config, string $ipAddress)
    {
        parent::__construct($config, $ipAddress);
        $session = config('Session');
        $this->sessionExpiration = ($session instanceof SessionConfig) ? $session->expiration : $config->sessionExpiration;
        if (empty($this->savePath)) {
            throw SessionException::forEmptySavepath();
        }
        $this->keyPrefix .= ($session instanceof SessionConfig) ? $session->cookieName : $config->sessionCookieName . ':';
        if ($this->matchIP === true) {
            $this->keyPrefix .= $this->ipAddress . ':';
        }
        if (!empty($this->keyPrefix)) {
            ini_set('memcached.sess_prefix', $this->keyPrefix);
        }
    }

    public function open($path, $name): bool
    {
        $this->memcached = new Memcached();
        $this->memcached->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
        $serverList = [];
        foreach ($this->memcached->getServerList() as $server) {
            $serverList[] = $server['host'] . ':' . $server['port'];
        }
        if (!preg_match_all('#,?([^,:]+)\:(\d{1,5})(?:\:(\d+))?#', $this->savePath, $matches, PREG_SET_ORDER)) {
            $this->memcached = null;
            $this->logger->error('Session: Invalid Memcached save path format: ' . $this->savePath);
            return false;
        }
        foreach ($matches as $match) {
            if (in_array($match[1] . ':' . $match[2], $serverList, true)) {
                $this->logger->debug('Session: Memcached server pool already has ' . $match[1] . ':' . $match[2]);
                continue;
            }
            if (!$this->memcached->addServer($match[1], (int)$match[2], $match[3] ?? 0)) {
                $this->logger->error('Could not add ' . $match[1] . ':' . $match[2] . ' to Memcached server pool.');
            } else {
                $serverList[] = $match[1] . ':' . $match[2];
            }
        }
        if (empty($serverList)) {
            $this->logger->error('Session: Memcached server pool is empty.');
            return false;
        }
        return true;
    }

    #[ReturnTypeWillChange] public function read($id)
    {
        if (isset($this->memcached) && $this->lockSession($id)) {
            if (!isset($this->sessionID)) {
                $this->sessionID = $id;
            }
            $data = (string)$this->memcached->get($this->keyPrefix . $id);
            $this->fingerprint = md5($data);
            return $data;
        }
        return '';
    }

    protected function lockSession(string $sessionID): bool
    {
        if (isset($this->lockKey)) {
            return $this->memcached->replace($this->lockKey, Time::now()->getTimestamp(), 300);
        }
        $lockKey = $this->keyPrefix . $sessionID . ':lock';
        $attempt = 0;
        do {
            if ($this->memcached->get($lockKey)) {
                sleep(1);
                continue;
            }
            if (!$this->memcached->set($lockKey, Time::now()->getTimestamp(), 300)) {
                $this->logger->error('Session: Error while trying to obtain lock for ' . $this->keyPrefix . $sessionID);
                return false;
            }
            $this->lockKey = $lockKey;
            break;
        } while (++$attempt < 30);
        if ($attempt === 30) {
            $this->logger->error('Session: Unable to obtain lock for ' . $this->keyPrefix . $sessionID . ' after 30 attempts, aborting.');
            return false;
        }
        $this->lock = true;
        return true;
    }

    public function write($id, $data): bool
    {
        if (!isset($this->memcached)) {
            return false;
        }
        if ($this->sessionID !== $id) {
            if (!$this->releaseLock() || !$this->lockSession($id)) {
                return false;
            }
            $this->fingerprint = md5('');
            $this->sessionID = $id;
        }
        if (isset($this->lockKey)) {
            $this->memcached->replace($this->lockKey, Time::now()->getTimestamp(), 300);
            if ($this->fingerprint !== ($fingerprint = md5($data))) {
                if ($this->memcached->set($this->keyPrefix . $id, $data, $this->sessionExpiration)) {
                    $this->fingerprint = $fingerprint;
                    return true;
                }
                return false;
            }
            return $this->memcached->touch($this->keyPrefix . $id, $this->sessionExpiration);
        }
        return false;
    }

    protected function releaseLock(): bool
    {
        if (isset($this->memcached, $this->lockKey) && $this->lock) {
            if (!$this->memcached->delete($this->lockKey) && $this->memcached->getResultCode() !== Memcached::RES_NOTFOUND) {
                $this->logger->error('Session: Error while trying to free lock for ' . $this->lockKey);
                return false;
            }
            $this->lockKey = null;
            $this->lock = false;
        }
        return true;
    }

    public function close(): bool
    {
        if (isset($this->memcached)) {
            if (isset($this->lockKey)) {
                $this->memcached->delete($this->lockKey);
            }
            if (!$this->memcached->quit()) {
                return false;
            }
            $this->memcached = null;
            return true;
        }
        return false;
    }

    public function destroy($id): bool
    {
        if (isset($this->memcached, $this->lockKey)) {
            $this->memcached->delete($this->keyPrefix . $id);
            return $this->destroyCookie();
        }
        return false;
    }

    #[ReturnTypeWillChange] public function gc($max_lifetime)
    {
        return 1;
    }
}