<?php

namespace Twilio\Rest\Preview\Wireless\Sim;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class UsageContext extends InstanceContext
{
    public function __construct(Version $version, $simSid)
    {
        parent::__construct($version);
        $this->solution = ['simSid' => $simSid,];
        $this->uri = '/Sims/' . rawurlencode($simSid) . '/Usage';
    }

    public function fetch(array $options = []): UsageInstance
    {
        $options = new Values($options);
        $params = Values::of(['End' => $options['end'], 'Start' => $options['start'],]);
        $payload = $this->version->fetch('GET', $this->uri, $params);
        return new UsageInstance($this->version, $payload, $this->solution['simSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.Wireless.UsageContext ' . implode(' ', $context) . ']';
    }
}