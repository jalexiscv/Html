<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class CpsInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload)
    {
        parent::__construct($version);
        $this->properties = ['cpsUrl' => Values::array_get($payload, 'cps_url'), 'phoneNumber' => Values::array_get($payload, 'phone_number'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = [];
    }

    protected function proxy(): CpsContext
    {
        if (!$this->context) {
            $this->context = new CpsContext($this->version);
        }
        return $this->context;
    }

    public function fetch(array $options = []): CpsInstance
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
        return '[Twilio.Preview.TrustedComms.CpsInstance ' . implode(' ', $context) . ']';
    }
}