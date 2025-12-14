<?php

namespace Twilio\Rest\Api\V2010\Account\Call;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class EventInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid, string $callSid)
    {
        parent::__construct($version);
        $this->properties = ['request' => Values::array_get($payload, 'request'), 'response' => Values::array_get($payload, 'response'),];
        $this->solution = ['accountSid' => $accountSid, 'callSid' => $callSid,];
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
        return '[Twilio.Api.V2010.EventInstance]';
    }
}