<?php

namespace Twilio\Rest\IpMessaging\V2\Service\User;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class UserBindingInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $userSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'endpoint' => Values::array_get($payload, 'endpoint'), 'identity' => Values::array_get($payload, 'identity'), 'userSid' => Values::array_get($payload, 'user_sid'), 'credentialSid' => Values::array_get($payload, 'credential_sid'), 'bindingType' => Values::array_get($payload, 'binding_type'), 'messageTypes' => Values::array_get($payload, 'message_types'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['serviceSid' => $serviceSid, 'userSid' => $userSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): UserBindingContext
    {
        if (!$this->context) {
            $this->context = new UserBindingContext($this->version, $this->solution['serviceSid'], $this->solution['userSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): UserBindingInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
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
        return '[Twilio.IpMessaging.V2.UserBindingInstance ' . implode(' ', $context) . ']';
    }
}