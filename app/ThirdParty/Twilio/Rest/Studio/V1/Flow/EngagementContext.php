<?php

namespace Twilio\Rest\Studio\V1\Flow;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Studio\V1\Flow\Engagement\EngagementContextContext;
use Twilio\Rest\Studio\V1\Flow\Engagement\EngagementContextList;
use Twilio\Rest\Studio\V1\Flow\Engagement\StepContext;
use Twilio\Rest\Studio\V1\Flow\Engagement\StepList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class EngagementContext extends InstanceContext
{
    protected $_steps;
    protected $_engagementContext;

    public function __construct(Version $version, $flowSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['flowSid' => $flowSid, 'sid' => $sid,];
        $this->uri = '/Flows/' . rawurlencode($flowSid) . '/Engagements/' . rawurlencode($sid) . '';
    }

    public function fetch(): EngagementInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new EngagementInstance($this->version, $payload, $this->solution['flowSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getSteps(): StepList
    {
        if (!$this->_steps) {
            $this->_steps = new StepList($this->version, $this->solution['flowSid'], $this->solution['sid']);
        }
        return $this->_steps;
    }

    protected function getEngagementContext(): EngagementContextList
    {
        if (!$this->_engagementContext) {
            $this->_engagementContext = new EngagementContextList($this->version, $this->solution['flowSid'], $this->solution['sid']);
        }
        return $this->_engagementContext;
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
        return '[Twilio.Studio.V1.EngagementContext ' . implode(' ', $context) . ']';
    }
}