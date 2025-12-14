<?php

namespace Twilio\Rest\Conversations\V1\Service\Configuration;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class NotificationContext extends InstanceContext
{
    public function __construct(Version $version, $chatServiceSid)
    {
        parent::__construct($version);
        $this->solution = ['chatServiceSid' => $chatServiceSid,];
        $this->uri = '/Services/' . rawurlencode($chatServiceSid) . '/Configuration/Notifications';
    }

    public function update(array $options = []): NotificationInstance
    {
        $options = new Values($options);
        $data = Values::of(['LogEnabled' => Serialize::booleanToString($options['logEnabled']), 'NewMessage.Enabled' => Serialize::booleanToString($options['newMessageEnabled']), 'NewMessage.Template' => $options['newMessageTemplate'], 'NewMessage.Sound' => $options['newMessageSound'], 'NewMessage.BadgeCountEnabled' => Serialize::booleanToString($options['newMessageBadgeCountEnabled']), 'AddedToConversation.Enabled' => Serialize::booleanToString($options['addedToConversationEnabled']), 'AddedToConversation.Template' => $options['addedToConversationTemplate'], 'AddedToConversation.Sound' => $options['addedToConversationSound'], 'RemovedFromConversation.Enabled' => Serialize::booleanToString($options['removedFromConversationEnabled']), 'RemovedFromConversation.Template' => $options['removedFromConversationTemplate'], 'RemovedFromConversation.Sound' => $options['removedFromConversationSound'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new NotificationInstance($this->version, $payload, $this->solution['chatServiceSid']);
    }

    public function fetch(): NotificationInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new NotificationInstance($this->version, $payload, $this->solution['chatServiceSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Conversations.V1.NotificationContext ' . implode(' ', $context) . ']';
    }
}