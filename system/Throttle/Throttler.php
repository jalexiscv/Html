<?php

namespace Higgs\Throttle;

use Higgs\Cache\CacheInterface;
use Higgs\I18n\Time;

class Throttler implements ThrottlerInterface
{
    protected $cache;
    protected $tokenTime = 0;
    protected $prefix = 'throttler_';
    protected $testTime;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function getTokenTime(): int
    {
        return $this->tokenTime;
    }

    public function check(string $key, int $capacity, int $seconds, int $cost = 1): bool
    {
        $tokenName = $this->prefix . $key;
        $rate = $capacity / $seconds;
        $refresh = 1 / $rate;
        if (($tokens = $this->cache->get($tokenName)) === null) {
            $tokens = $capacity - $cost;
            $this->cache->save($tokenName, $tokens, $seconds);
            $this->cache->save($tokenName . 'Time', $this->time(), $seconds);
            $this->tokenTime = 0;
            return true;
        }
        $throttleTime = $this->cache->get($tokenName . 'Time');
        $elapsed = $this->time() - $throttleTime;
        $tokens += $rate * $elapsed;
        $tokens = $tokens > $capacity ? $capacity : $tokens;
        if ($tokens >= 1) {
            $tokens = $tokens - $cost;
            $this->cache->save($tokenName, $tokens, $seconds);
            $this->cache->save($tokenName . 'Time', $this->time(), $seconds);
            $this->tokenTime = 0;
            return true;
        }
        $newTokenAvailable = (int)($refresh - $elapsed - $refresh * $tokens);
        $this->tokenTime = max(1, $newTokenAvailable);
        return false;
    }

    public function time(): int
    {
        return $this->testTime ?? Time::now()->getTimestamp();
    }

    public function remove(string $key): self
    {
        $tokenName = $this->prefix . $key;
        $this->cache->delete($tokenName);
        $this->cache->delete($tokenName . 'Time');
        return $this;
    }

    public function setTestTime(int $time)
    {
        $this->testTime = $time;
        return $this;
    }
}