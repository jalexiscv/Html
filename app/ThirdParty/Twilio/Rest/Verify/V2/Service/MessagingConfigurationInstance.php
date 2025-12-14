<?php

namespace Twilio\Rest\Verify\V2\Service;

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

class MessagingConfigurationInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $country = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'country' => Values::array_get($payload, 'country'), 'messagingServiceSid' => Values::array_get($payload, 'messaging_service_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['serviceSid' => $serviceSid, 'country' => $country ?: $this->properties['country'],];
    }

    protected function proxy(): MessagingConfigurationContext
    {
        if (!$this->context) {
            $this->context = new MessagingConfigurationContext($this->version, $this->solution['serviceSid'], $this->solution['country']);
        }
        return $this->context;
    }

    public function update(string $messagingServiceSid): MessagingConfigurationInstance
    {
        return $this->proxy()->update($messagingServiceSid);
    }

    public function fetch(): MessagingConfigurationInstance
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
        return '[Twilio.Verify.V2.MessagingConfigurationInstance ' . implode(' ', $context) . ']';
    }
}