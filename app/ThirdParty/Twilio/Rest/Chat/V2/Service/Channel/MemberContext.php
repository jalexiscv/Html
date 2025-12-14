<?php

namespace Twilio\Rest\Chat\V2\Service\Channel;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
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

    public function delete(array $options = []): bool
    {
        $options = new Values($options);
        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled'],]);
        return $this->version->delete('DELETE', $this->uri, [], [], $headers);
    }

    public function update(array $options = []): MemberInstance
    {
        $options = new Values($options);
        $data = Values::of(['RoleSid' => $options['roleSid'], 'LastConsumedMessageIndex' => $options['lastConsumedMessageIndex'], 'LastConsumptionTimestamp' => Serialize::iso8601DateTime($options['lastConsumptionTimestamp']), 'DateCreated' => Serialize::iso8601DateTime($options['dateCreated']), 'DateUpdated' => Serialize::iso8601DateTime($options['dateUpdated']), 'Attributes' => $options['attributes'],]);
        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data, $headers);
        return new MemberInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['channelSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Chat.V2.MemberContext ' . implode(' ', $context) . ']';
    }
}