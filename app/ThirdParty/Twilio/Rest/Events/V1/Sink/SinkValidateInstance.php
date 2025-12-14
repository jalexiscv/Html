<?php

namespace Twilio\Rest\Events\V1\Sink;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class SinkValidateInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $sid)
    {
        parent::__construct($version);
        $this->properties = ['result' => Values::array_get($payload, 'result'),];
        $this->solution = ['sid' => $sid,];
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
        return '[Twilio.Events.V1.SinkValidateInstance]';
    }
}