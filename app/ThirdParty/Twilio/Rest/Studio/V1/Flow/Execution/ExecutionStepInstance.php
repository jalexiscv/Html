<?php

namespace Twilio\Rest\Studio\V1\Flow\Execution;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Studio\V1\Flow\Execution\ExecutionStep\ExecutionStepContextList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ExecutionStepInstance extends InstanceResource
{
    protected $_stepContext;

    public function __construct(Version $version, array $payload, string $flowSid, string $executionSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'flowSid' => Values::array_get($payload, 'flow_sid'), 'executionSid' => Values::array_get($payload, 'execution_sid'), 'name' => Values::array_get($payload, 'name'), 'context' => Values::array_get($payload, 'context'), 'transitionedFrom' => Values::array_get($payload, 'transitioned_from'), 'transitionedTo' => Values::array_get($payload, 'transitioned_to'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['flowSid' => $flowSid, 'executionSid' => $executionSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ExecutionStepContext
    {
        if (!$this->context) {
            $this->context = new ExecutionStepContext($this->version, $this->solution['flowSid'], $this->solution['executionSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): ExecutionStepInstance
    {
        return $this->proxy()->fetch();
    }

    protected function getStepContext(): ExecutionStepContextList
    {
        return $this->proxy()->stepContext;
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
        return '[Twilio.Studio.V1.ExecutionStepInstance ' . implode(' ', $context) . ']';
    }
}