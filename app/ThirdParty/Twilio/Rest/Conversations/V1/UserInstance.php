<?php

namespace Twilio\Rest\Conversations\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class UserInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'chatServiceSid' => Values::array_get($payload, 'chat_service_sid'), 'roleSid' => Values::array_get($payload, 'role_sid'), 'identity' => Values::array_get($payload, 'identity'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'attributes' => Values::array_get($payload, 'attributes'), 'isOnline' => Values::array_get($payload, 'is_online'), 'isNotifiable' => Values::array_get($payload, 'is_notifiable'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): UserContext
    {
        if (!$this->context) {
            $this->context = new UserContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function update(array $options = []): UserInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(array $options = []): bool
    {
        return $this->proxy()->delete($options);
    }

    public function fetch(): UserInstance
    {
        return $this->proxy()->fetch();
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
        return '[Twilio.Conversations.V1.UserInstance ' . implode(' ', $context) . ']';
    }
}