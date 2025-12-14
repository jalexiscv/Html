<?php

namespace Twilio\Rest\Conversations\V1\Conversation;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class ParticipantContext extends InstanceContext
{
    public function __construct(Version $version, $conversationSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['conversationSid' => $conversationSid, 'sid' => $sid,];
        $this->uri = '/Conversations/' . rawurlencode($conversationSid) . '/Participants/' . rawurlencode($sid) . '';
    }

    public function update(array $options = []): ParticipantInstance
    {
        $options = new Values($options);
        $data = Values::of(['DateCreated' => Serialize::iso8601DateTime($options['dateCreated']), 'DateUpdated' => Serialize::iso8601DateTime($options['dateUpdated']), 'Attributes' => $options['attributes'], 'RoleSid' => $options['roleSid'], 'MessagingBinding.ProxyAddress' => $options['messagingBindingProxyAddress'], 'MessagingBinding.ProjectedAddress' => $options['messagingBindingProjectedAddress'], 'Identity' => $options['identity'], 'LastReadMessageIndex' => $options['lastReadMessageIndex'], 'LastReadTimestamp' => $options['lastReadTimestamp'],]);
        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data, $headers);
        return new ParticipantInstance($this->version, $payload, $this->solution['conversationSid'], $this->solution['sid']);
    }

    public function delete(array $options = []): bool
    {
        $options = new Values($options);
        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled'],]);
        return $this->version->delete('DELETE', $this->uri, [], [], $headers);
    }

    public function fetch(): ParticipantInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ParticipantInstance($this->version, $payload, $this->solution['conversationSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Conversations.V1.ParticipantContext ' . implode(' ', $context) . ']';
    }
}