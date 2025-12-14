<?php

namespace Twilio\Rest\Autopilot\V1\Assistant;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class DialogueInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $assistantSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'assistantSid' => Values::array_get($payload, 'assistant_sid'), 'sid' => Values::array_get($payload, 'sid'), 'data' => Values::array_get($payload, 'data'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['assistantSid' => $assistantSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): DialogueContext
    {
        if (!$this->context) {
            $this->context = new DialogueContext($this->version, $this->solution['assistantSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): DialogueInstance
    {
        return $this->proxy()->fetch();
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
        return '[Twilio.Autopilot.V1.DialogueInstance ' . implode(' ', $context) . ']';
    }
}