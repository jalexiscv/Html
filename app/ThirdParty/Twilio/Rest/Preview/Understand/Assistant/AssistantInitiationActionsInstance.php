<?php

namespace Twilio\Rest\Preview\Understand\Assistant;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class AssistantInitiationActionsInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $assistantSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'assistantSid' => Values::array_get($payload, 'assistant_sid'), 'url' => Values::array_get($payload, 'url'), 'data' => Values::array_get($payload, 'data'),];
        $this->solution = ['assistantSid' => $assistantSid,];
    }

    protected function proxy(): AssistantInitiationActionsContext
    {
        if (!$this->context) {
            $this->context = new AssistantInitiationActionsContext($this->version, $this->solution['assistantSid']);
        }
        return $this->context;
    }

    public function fetch(): AssistantInitiationActionsInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): AssistantInitiationActionsInstance
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
        return '[Twilio.Preview.Understand.AssistantInitiationActionsInstance ' . implode(' ', $context) . ']';
    }
}