<?php

namespace Twilio\Rest\Studio\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Studio\V1\Flow\EngagementContext;
use Twilio\Rest\Studio\V1\Flow\EngagementList;
use Twilio\Rest\Studio\V1\Flow\ExecutionContext;
use Twilio\Rest\Studio\V1\Flow\ExecutionList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class FlowContext extends InstanceContext
{
    protected $_engagements;
    protected $_executions;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Flows/' . rawurlencode($sid) . '';
    }

    public function fetch(): FlowInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new FlowInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
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
        return '[Twilio.Studio.V1.FlowContext ' . implode(' ', $context) . ']';
    }

    protected function getEngagements(): EngagementList
    {
        if (!$this->_engagements) {
            $this->_engagements = new EngagementList($this->version, $this->solution['sid']);
        }
        return $this->_engagements;
    }

    protected function getExecutions(): ExecutionList
    {
        if (!$this->_executions) {
            $this->_executions = new ExecutionList($this->version, $this->solution['sid']);
        }
        return $this->_executions;
    }
}