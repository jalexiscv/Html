<?php

namespace Twilio\Rest\Messaging\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class DeactivationsInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload)
    {
        parent::__construct($version);
        $this->properties = ['redirectTo' => Values::array_get($payload, 'redirect_to'),];
        $this->solution = [];
    }

    protected function proxy(): DeactivationsContext
    {
        if (!$this->context) {
            $this->context = new DeactivationsContext($this->version);
        }
        return $this->context;
    }

    public function fetch(array $options = []): DeactivationsInstance
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
        return '[Twilio.Messaging.V1.DeactivationsInstance ' . implode(' ', $context) . ']';
    }
}