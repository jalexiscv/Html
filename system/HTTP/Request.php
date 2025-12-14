<?php

namespace Higgs\HTTP;

use Higgs\Validation\FormatRules;
use Config\App;

class Request extends OutgoingRequest implements RequestInterface
{
    use RequestTrait;

    protected $proxyIPs;

    public function __construct($config = null)
    {
        $this->proxyIPs = $config->proxyIPs;
        if (empty($this->method)) {
            $this->method = $this->getServer('REQUEST_METHOD') ?? 'GET';
        }
        if (empty($this->uri)) {
            $this->uri = new URI();
        }
    }

    public function isValidIP(?string $ip = null, ?string $which = null): bool
    {
        return (new FormatRules())->valid_ip($ip, $which);
    }

    public function getMethod(bool $upper = false): string
    {
        return ($upper) ? strtoupper($this->method) : strtolower($this->method);
    }

    public function setMethod(string $method)
    {
        $this->method = $method;
        return $this;
    }

    public function withMethod($method)
    {
        $request = clone $this;
        $request->method = $method;
        return $request;
    }

    public function getUri()
    {
        return $this->uri;
    }
}