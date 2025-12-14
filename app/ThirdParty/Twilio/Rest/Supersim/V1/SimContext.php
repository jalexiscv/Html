<?php

namespace Twilio\Rest\Supersim\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class SimContext extends InstanceContext
{
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Sims/' . rawurlencode($sid) . '';
    }

    public function fetch(): SimInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SimInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): SimInstance
    {
        $options = new Values($options);
        $data = Values::of(['UniqueName' => $options['uniqueName'], 'Status' => $options['status'], 'Fleet' => $options['fleet'], 'CallbackUrl' => $options['callbackUrl'], 'CallbackMethod' => $options['callbackMethod'], 'AccountSid' => $options['accountSid'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new SimInstance($this->version, $payload, $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Supersim.V1.SimContext ' . implode(' ', $context) . ']';
    }
}