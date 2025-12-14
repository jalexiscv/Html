<?php

namespace Twilio\Rest\Voice\V1\DialingPermissions\Country;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class HighriskSpecialPrefixInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $isoCode)
    {
        parent::__construct($version);
        $this->properties = ['prefix' => Values::array_get($payload, 'prefix'),];
        $this->solution = ['isoCode' => $isoCode,];
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
        return '[Twilio.Voice.V1.HighriskSpecialPrefixInstance]';
    }
}