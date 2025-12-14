<?php

namespace Twilio\Rest\Preview\TrustedComms\Business;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class InsightsInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $businessSid)
    {
        parent::__construct($version);
        $this->solution = ['businessSid' => $businessSid,];
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
        return '[Twilio.Preview.TrustedComms.InsightsInstance]';
    }
}