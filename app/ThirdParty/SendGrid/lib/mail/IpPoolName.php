<?php

namespace SendGrid\Mail;

use JsonSerializable;

class IpPoolName implements JsonSerializable
{
    private $ip_pool_name;

    public function __construct($ip_pool_name = null)
    {
        if (isset($ip_pool_name)) {
            $this->setIpPoolName($ip_pool_name);
        }
    }

    public function setIpPoolName($ip_pool_name)
    {
        if (!is_string($ip_pool_name)) {
            throw new TypeException('$ip_pool_name must be of type string.');
        }
        $this->ip_pool_name = $ip_pool_name;
    }

    public function getIpPoolName()
    {
        return $this->ip_pool_name;
    }

    public function jsonSerialize()
    {
        return $this->getIpPoolName();
    }
}
