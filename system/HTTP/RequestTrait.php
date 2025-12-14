<?php

namespace Higgs\HTTP;

use Higgs\Exceptions\ConfigException;
use Higgs\Validation\FormatRules;

trait RequestTrait
{
    protected $ipAddress = '';
    protected $globals = [];

    public function getIPAddress(): string
    {
        if ($this->ipAddress) {
            return $this->ipAddress;
        }
        $ipValidator = [new FormatRules(), 'valid_ip',];
        $proxyIPs = $this->proxyIPs ?? config('App')->proxyIPs;
        if (!empty($proxyIPs) && (!is_array($proxyIPs) || is_int(array_key_first($proxyIPs)))) {
            throw new ConfigException('You must set an array with Proxy IP address key and HTTP header name value in Config\App::$proxyIPs.');
        }
        $this->ipAddress = $this->getServer('REMOTE_ADDR');
        if ($this->ipAddress === null) {
            return $this->ipAddress = '0.0.0.0';
        }
        if ($proxyIPs) {
            foreach ($proxyIPs as $proxyIP => $header) {
                if (strpos($proxyIP, '/') === false) {
                    if ($proxyIP === $this->ipAddress) {
                        $spoof = $this->getClientIP($header);
                        if ($spoof !== null) {
                            $this->ipAddress = $spoof;
                            break;
                        }
                    }
                    continue;
                }
                if (!isset($separator)) {
                    $separator = $ipValidator($this->ipAddress, 'ipv6') ? ':' : '.';
                }
                if (strpos($proxyIP, $separator) === false) {
                    continue;
                }
                if (!isset($ip, $sprintf)) {
                    if ($separator === ':') {
                        $ip = explode(':', str_replace('::', str_repeat(':', 9 - substr_count($this->ipAddress, ':')), $this->ipAddress));
                        for ($j = 0; $j < 8; $j++) {
                            $ip[$j] = intval($ip[$j], 16);
                        }
                        $sprintf = '%016b%016b%016b%016b%016b%016b%016b%016b';
                    } else {
                        $ip = explode('.', $this->ipAddress);
                        $sprintf = '%08b%08b%08b%08b';
                    }
                    $ip = vsprintf($sprintf, $ip);
                }
                sscanf($proxyIP, '%[^/]/%d', $netaddr, $masklen);
                if ($separator === ':') {
                    $netaddr = explode(':', str_replace('::', str_repeat(':', 9 - substr_count($netaddr, ':')), $netaddr));
                    for ($i = 0; $i < 8; $i++) {
                        $netaddr[$i] = intval($netaddr[$i], 16);
                    }
                } else {
                    $netaddr = explode('.', $netaddr);
                }
                if (strncmp($ip, vsprintf($sprintf, $netaddr), $masklen) === 0) {
                    $spoof = $this->getClientIP($header);
                    if ($spoof !== null) {
                        $this->ipAddress = $spoof;
                        break;
                    }
                }
            }
        }
        if (!$ipValidator($this->ipAddress)) {
            return $this->ipAddress = '0.0.0.0';
        }
        return $this->ipAddress;
    }

    public function getServer($index = null, $filter = null, $flags = null)
    {
        return $this->fetchGlobal('server', $index, $filter, $flags);
    }

    public function fetchGlobal(string $method, $index = null, ?int $filter = null, $flags = null)
    {
        $method = strtolower($method);
        if (!isset($this->globals[$method])) {
            $this->populateGlobals($method);
        }
        $filter ??= FILTER_DEFAULT;
        $flags = is_array($flags) ? $flags : (is_numeric($flags) ? (int)$flags : 0);
        if ($index === null) {
            $values = [];
            foreach ($this->globals[$method] as $key => $value) {
                $values[$key] = is_array($value) ? $this->fetchGlobal($method, $key, $filter, $flags) : filter_var($value, $filter, $flags);
            }
            return $values;
        }
        if (is_array($index)) {
            $output = [];
            foreach ($index as $key) {
                $output[$key] = $this->fetchGlobal($method, $key, $filter, $flags);
            }
            return $output;
        }
        if (($count = preg_match_all('/(?:^[^\[]+)|\[[^]]*\]/', $index, $matches)) > 1) {
            $value = $this->globals[$method];
            for ($i = 0; $i < $count; $i++) {
                $key = trim($matches[0][$i], '[]');
                if ($key === '') {
                    break;
                }
                if (isset($value[$key])) {
                    $value = $value[$key];
                } else {
                    return null;
                }
            }
        }
        if (!isset($value)) {
            $value = $this->globals[$method][$index] ?? null;
        }
        if (is_array($value) && ($filter !== FILTER_DEFAULT || ((is_numeric($flags) && $flags !== 0) || is_array($flags) && $flags !== []))) {
            array_walk_recursive($value, static function (&$val) use ($filter, $flags) {
                $val = filter_var($val, $filter, $flags);
            });
            return $value;
        }
        if (is_array($value) || is_object($value) || $value === null) {
            return $value;
        }
        return filter_var($value, $filter, $flags);
    }

    protected function populateGlobals(string $method)
    {
        if (!isset($this->globals[$method])) {
            $this->globals[$method] = [];
        }
        switch ($method) {
            case 'get':
                $this->globals['get'] = $_GET;
                break;
            case 'post':
                $this->globals['post'] = $_POST;
                break;
            case 'request':
                $this->globals['request'] = $_REQUEST;
                break;
            case 'cookie':
                $this->globals['cookie'] = $_COOKIE;
                break;
            case 'server':
                $this->globals['server'] = $_SERVER;
                break;
        }
    }

    private function getClientIP(string $header): ?string
    {
        $ipValidator = [new FormatRules(), 'valid_ip',];
        $spoof = null;
        $headerObj = $this->header($header);
        if ($headerObj !== null) {
            $spoof = $headerObj->getValue();
            sscanf($spoof, '%[^,]', $spoof);
            if (!$ipValidator($spoof)) {
                $spoof = null;
            }
        }
        return $spoof;
    }

    public function getEnv($index = null, $filter = null, $flags = null)
    {
        return $this->fetchGlobal('env', $index, $filter, $flags);
    }

    public function setGlobal(string $method, $value)
    {
        $this->globals[$method] = $value;
        return $this;
    }
}