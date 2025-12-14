<?php

namespace Twilio\Rest\Api\V2010\Account\Queue;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class MemberContext extends InstanceContext
{
    public function __construct(Version $version, $accountSid, $queueSid, $callSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'queueSid' => $queueSid, 'callSid' => $callSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Queues/' . rawurlencode($queueSid) . '/Members/' . rawurlencode($callSid) . '.json';
    }

    public function fetch(): MemberInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new MemberInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['queueSid'], $this->solution['callSid']);
    }

    public function update(string $url, array $options = []): MemberInstance
    {
        $options = new Values($options);
        $data = Values::of(['Url' => $url, 'Method' => $options['method'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new MemberInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['queueSid'], $this->solution['callSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.MemberContext ' . implode(' ', $context) . ']';
    }
}