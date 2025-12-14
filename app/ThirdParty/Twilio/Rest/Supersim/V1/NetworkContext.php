<?php

namespace Twilio\Rest\Supersim\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class NetworkContext extends InstanceContext
{
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Networks/' . rawurlencode($sid) . '';
    }

    public function fetch(): NetworkInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new NetworkInstance($this->version, $payload, $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Supersim.V1.NetworkContext ' . implode(' ', $context) . ']';
    }
}