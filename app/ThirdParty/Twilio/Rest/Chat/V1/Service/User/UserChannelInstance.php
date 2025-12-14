<?php

namespace Twilio\Rest\Chat\V1\Service\User;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class UserChannelInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $userSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'channelSid' => Values::array_get($payload, 'channel_sid'), 'memberSid' => Values::array_get($payload, 'member_sid'), 'status' => Values::array_get($payload, 'status'), 'lastConsumedMessageIndex' => Values::array_get($payload, 'last_consumed_message_index'), 'unreadMessagesCount' => Values::array_get($payload, 'unread_messages_count'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['serviceSid' => $serviceSid, 'userSid' => $userSid,];
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
        return '[Twilio.Chat.V1.UserChannelInstance]';
    }
}