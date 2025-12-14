<?php

namespace Twilio\Rest\Lookups\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class PhoneNumberInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $phoneNumber = null)
    {
        parent::__construct($version);
        $this->properties = ['callerName' => Values::array_get($payload, 'caller_name'), 'countryCode' => Values::array_get($payload, 'country_code'), 'phoneNumber' => Values::array_get($payload, 'phone_number'), 'nationalFormat' => Values::array_get($payload, 'national_format'), 'carrier' => Values::array_get($payload, 'carrier'), 'addOns' => Values::array_get($payload, 'add_ons'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['phoneNumber' => $phoneNumber ?: $this->properties['phoneNumber'],];
    }

    protected function proxy(): PhoneNumberContext
    {
        if (!$this->context) {
            $this->context = new PhoneNumberContext($this->version, $this->solution['phoneNumber']);
        }
        return $this->context;
    }

    public function fetch(array $options = []): PhoneNumberInstance
    {
        return $this->proxy()->fetch($options);
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
        return '[Twilio.Lookups.V1.PhoneNumberInstance ' . implode(' ', $context) . ']';
    }
}