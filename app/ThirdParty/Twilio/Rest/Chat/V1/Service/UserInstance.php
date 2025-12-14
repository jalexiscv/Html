<?php

namespace Twilio\Rest\Chat\V1\Service;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Chat\V1\Service\User\UserChannelList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class UserInstance extends InstanceResource
{
    protected $_userChannels;

    public function __construct(Version $version, array $payload, string $serviceSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'attributes' => Values::array_get($payload, 'attributes'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'roleSid' => Values::array_get($payload, 'role_sid'), 'identity' => Values::array_get($payload, 'identity'), 'isOnline' => Values::array_get($payload, 'is_online'), 'isNotifiable' => Values::array_get($payload, 'is_notifiable'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'joinedChannelsCount' => Values::array_get($payload, 'joined_channels_count'), 'links' => Values::array_get($payload, 'links'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): UserContext
    {
        if (!$this->context) {
            $this->context = new UserContext($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): UserInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(array $options = []): UserInstance
    {
        return $this->proxy()->update($options);
    }

    protected function getUserChannels(): UserChannelList
    {
        return $this->proxy()->userChannels;
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
        return '[Twilio.Chat.V1.UserInstance ' . implode(' ', $context) . ']';
    }
}