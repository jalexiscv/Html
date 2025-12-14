<?php

namespace Twilio\Rest\Verify\V2\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class AccessTokenInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid)
    {
        parent::__construct($version);
        $this->properties = ['token' => Values::array_get($payload, 'token'),];
        $this->solution = ['serviceSid' => $serviceSid,];
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
        return '[Twilio.Verify.V2.AccessTokenInstance]';
    }
}