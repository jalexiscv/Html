<?php

namespace Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class NationalInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid, string $countryCode)
    {
        parent::__construct($version);
        $this->properties = ['friendlyName' => Values::array_get($payload, 'friendly_name'), 'phoneNumber' => Values::array_get($payload, 'phone_number'), 'lata' => Values::array_get($payload, 'lata'), 'locality' => Values::array_get($payload, 'locality'), 'rateCenter' => Values::array_get($payload, 'rate_center'), 'latitude' => Values::array_get($payload, 'latitude'), 'longitude' => Values::array_get($payload, 'longitude'), 'region' => Values::array_get($payload, 'region'), 'postalCode' => Values::array_get($payload, 'postal_code'), 'isoCountry' => Values::array_get($payload, 'iso_country'), 'addressRequirements' => Values::array_get($payload, 'address_requirements'), 'beta' => Values::array_get($payload, 'beta'), 'capabilities' => Values::array_get($payload, 'capabilities'),];
        $this->solution = ['accountSid' => $accountSid, 'countryCode' => $countryCode,];
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
        return '[Twilio.Api.V2010.NationalInstance]';
    }
}