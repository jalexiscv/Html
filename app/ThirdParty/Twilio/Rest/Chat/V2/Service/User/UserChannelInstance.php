<?php

namespace Twilio\Rest\Chat\V2\Service\User;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class UserChannelInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $userSid, string $channelSid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'channelSid' => Values::array_get($payload, 'channel_sid'), 'userSid' => Values::array_get($payload, 'user_sid'), 'memberSid' => Values::array_get($payload, 'member_sid'), 'status' => Values::array_get($payload, 'status'), 'lastConsumedMessageIndex' => Values::array_get($payload, 'last_consumed_message_index'), 'unreadMessagesCount' => Values::array_get($payload, 'unread_messages_count'), 'links' => Values::array_get($payload, 'links'), 'url' => Values::array_get($payload, 'url'), 'notificationLevel' => Values::array_get($payload, 'notification_level'),];
        $this->solution = ['serviceSid' => $serviceSid, 'userSid' => $userSid, 'channelSid' => $channelSid ?: $this->properties['channelSid'],];
    }

    protected function proxy(): UserChannelContext
    {
        if (!$this->context) {
            $this->context = new UserChannelContext($this->version, $this->solution['serviceSid'], $this->solution['userSid'], $this->solution['channelSid']);
        }
        return $this->context;
    }

    public function fetch(): UserChannelInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(array $options = []): UserChannelInstance
    {
        return $this->proxy()->update($options);
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown property: ' . $name);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Chat.V2.UserChannelInstance ' . implode(' ', $context) . ']';
    }
}