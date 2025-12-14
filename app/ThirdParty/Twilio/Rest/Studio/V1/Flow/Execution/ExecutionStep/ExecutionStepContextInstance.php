<?php

namespace Twilio\Rest\Studio\V1\Flow\Execution\ExecutionStep;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ExecutionStepContextInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $flowSid, string $executionSid, string $stepSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'context' => Values::array_get($payload, 'context'), 'executionSid' => Values::array_get($payload, 'execution_sid'), 'flowSid' => Values::array_get($payload, 'flow_sid'), 'stepSid' => Values::array_get($payload, 'step_sid'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['flowSid' => $flowSid, 'executionSid' => $executionSid, 'stepSid' => $stepSid,];
    }

    protected function proxy(): ExecutionStepContextContext
    {
        if (!$this->context) {
            $this->context = new ExecutionStepContextContext($this->version, $this->solution['flowSid'], $this->solution['executionSid'], $this->solution['stepSid']);
        }
        return $this->context;
    }

    public function fetch(): ExecutionStepContextInstance
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
        return '[Twilio.Studio.V1.ExecutionStepContextInstance ' . implode(' ', $context) . ']';
    }
}