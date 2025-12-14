<?php

namespace Twilio\Rest\IpMessaging\V1\Service\Channel;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class MemberContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $channelSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'channelSid' => $channelSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Channels/' . rawurlencode($channelSid) . '/Members/' . rawurlencode($sid) . '';
    }

    public function fetch(): MemberInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new MemberInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['channelSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(array $options = []): MemberInstance
    {
        $options = new Values($options);
        $data = Values::of(['RoleSid' => $options['roleSid'], 'LastConsumedMessageIndex' => $options['lastConsumedMessageIndex'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new MemberInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['channelSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.IpMessaging.V1.MemberContext ' . implode(' ', $context) . ']';
    }
}