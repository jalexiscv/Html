<?php

namespace Twilio\Rest\Trunking\V1\Trunk;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class RecordingInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $trunkSid)
    {
        parent::__construct($version);
        $this->properties = ['mode' => Values::array_get($payload, 'mode'), 'trim' => Values::array_get($payload, 'trim'),];
        $this->solution = ['trunkSid' => $trunkSid,];
    }

    protected function proxy(): RecordingContext
    {
        if (!$this->context) {
            $this->context = new RecordingContext($this->version, $this->solution['trunkSid']);
        }
        return $this->context;
    }

    public function fetch(): RecordingInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): RecordingInstance
    {
        return $this->proxy()->update($options);
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
        return '[Twilio.Trunking.V1.RecordingInstance ' . implode(' ', $context) . ']';
    }
}