<?php

namespace Twilio\Rest\Studio\V2\Flow\Execution;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ExecutionContextInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $flowSid, string $executionSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'context' => Values::array_get($payload, 'context'), 'flowSid' => Values::array_get($payload, 'flow_sid'), 'executionSid' => Values::array_get($payload, 'execution_sid'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['flowSid' => $flowSid, 'executionSid' => $executionSid,];
    }

    protected function proxy(): ExecutionContextContext
    {
        if (!$this->context) {
            $this->context = new ExecutionContextContext($this->version, $this->solution['flowSid'], $this->solution['executionSid']);
        }
        return $this->context;
    }

    public function fetch(): ExecutionContextInstance
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
        return '[Twilio.Studio.V2.ExecutionContextInstance ' . implode(' ', $context) . ']';
    }
}