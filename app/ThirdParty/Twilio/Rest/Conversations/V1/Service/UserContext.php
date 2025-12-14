<?php

namespace Twilio\Rest\Conversations\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class UserContext extends InstanceContext
{
    public function __construct(Version $version, $chatServiceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['chatServiceSid' => $chatServiceSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($chatServiceSid) . '/Users/' . rawurlencode($sid) . '';
    }

    public function update(array $options = []): UserInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'Attributes' => $options['attributes'], 'RoleSid' => $options['roleSid'],]);
        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data, $headers);
        return new UserInstance($this->version, $payload, $this->solution['chatServiceSid'], $this->solution['sid']);
    }

    public function delete(array $options = []): bool
    {
        $options = new Values($options);
        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled'],]);
        return $this->version->delete('DELETE', $this->uri, [], [], $headers);
    }

    public function fetch(): UserInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new UserInstance($this->version, $payload, $this->solution['chatServiceSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Conversations.V1.UserContext ' . implode(' ', $context) . ']';
    }
}