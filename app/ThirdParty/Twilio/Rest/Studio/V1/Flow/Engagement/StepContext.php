<?php

namespace Twilio\Rest\Studio\V1\Flow\Engagement;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Studio\V1\Flow\Engagement\Step\StepContextContext;
use Twilio\Rest\Studio\V1\Flow\Engagement\Step\StepContextList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class StepContext extends InstanceContext
{
    protected $_stepContext;

    public function __construct(Version $version, $flowSid, $engagementSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['flowSid' => $flowSid, 'engagementSid' => $engagementSid, 'sid' => $sid,];
        $this->uri = '/Flows/' . rawurlencode($flowSid) . '/Engagements/' . rawurlencode($engagementSid) . '/Steps/' . rawurlencode($sid) . '';
    }

    public function fetch(): StepInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new StepInstance($this->version, $payload, $this->solution['flowSid'], $this->solution['engagementSid'], $this->solution['sid']);
    }

    protected function getStepContext(): StepContextList
    {
        if (!$this->_stepContext) {
            $this->_stepContext = new StepContextList($this->version, $this->solution['flowSid'], $this->solution['engagementSid'], $this->solution['sid']);
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
        return '[Twilio.Studio.V1.StepContext ' . implode(' ', $context) . ']';
    }
}