<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class ValidationRequestInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'callSid' => Values::array_get($payload, 'call_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'phoneNumber' => Values::array_get($payload, 'phone_number'), 'validationCode' => Values::array_get($payload, 'validation_code'),];
        $this->solution = ['accountSid' => $accountSid,];
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
        return '[Twilio.Api.V2010.ValidationRequestInstance]';
    }
}