<?php

namespace Twilio\Rest\Studio\V2\Flow;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Studio\V2\Flow\Execution\ExecutionContextContext;
use Twilio\Rest\Studio\V2\Flow\Execution\ExecutionContextList;
use Twilio\Rest\Studio\V2\Flow\Execution\ExecutionStepContext;
use Twilio\Rest\Studio\V2\Flow\Execution\ExecutionStepList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class ExecutionContext extends InstanceContext
{
    protected $_steps;
    protected $_executionContext;

    public function __construct(Version $version, $flowSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['flowSid' => $flowSid, 'sid' => $sid,];
        $this->uri = '/Flows/' . rawurlencode($flowSid) . '/Executions/' . rawurlencode($sid) . '';
    }

    public function fetch(): ExecutionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ExecutionInstance($this->version, $payload, $this->solution['flowSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(string $status): ExecutionInstance
    {
        $data = Values::of(['Status' => $status,]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ExecutionInstance($this->version, $payload, $this->solution['flowSid'], $this->solution['sid']);
    }

    protected function getSteps(): ExecutionStepList
    {
        if (!$this->_steps) {
            $this->_steps = new ExecutionStepList($this->version, $this->solution['flowSid'], $this->solution['sid']);
        }
        return $this->_steps;
    }

    protected function getExecutionContext(): ExecutionContextList
    {
        if (!$this->_executionContext) {
            $this->_executionContext = new ExecutionContextList($this->version, $this->solution['flowSid'], $this->solution['sid']);
        }
        return $this->_executionContext;
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
        return '[Twilio.Studio.V2.ExecutionContext ' . implode(' ', $context) . ']';
    }
}