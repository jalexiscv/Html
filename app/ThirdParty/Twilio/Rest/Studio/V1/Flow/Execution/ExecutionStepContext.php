<?php

namespace Twilio\Rest\Studio\V1\Flow\Execution;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Studio\V1\Flow\Execution\ExecutionStep\ExecutionStepContextContext;
use Twilio\Rest\Studio\V1\Flow\Execution\ExecutionStep\ExecutionStepContextList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class ExecutionStepContext extends InstanceContext
{
    protected $_stepContext;

    public function __construct(Version $version, $flowSid, $executionSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['flowSid' => $flowSid, 'executionSid' => $executionSid, 'sid' => $sid,];
        $this->uri = '/Flows/' . rawurlencode($flowSid) . '/Executions/' . rawurlencode($executionSid) . '/Steps/' . rawurlencode($sid) . '';
    }

    public function fetch(): ExecutionStepInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ExecutionStepInstance($this->version, $payload, $this->solution['flowSid'], $this->solution['executionSid'], $this->solution['sid']);
    }

    protected function getStepContext(): ExecutionStepContextList
    {
        if (!$this->_stepContext) {
            $this->_stepContext = new ExecutionStepContextList($this->version, $this->solution['flowSid'], $this->solution['executionSid'], $this->solution['sid']);
        }
        return $this->_stepContext;
    }

    public function __get(string $name): ListResource
    {
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown subresource ' . $name);
    }

    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }
        throw new TwilioException('Resource does not have a context');
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Studio.V1.ExecutionStepContext ' . implode(' ', $context) . ']';
    }
}