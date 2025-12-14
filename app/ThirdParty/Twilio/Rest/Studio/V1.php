<?php

namespace Twilio\Rest\Studio;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Studio\V1\FlowContext;
use Twilio\Rest\Studio\V1\FlowList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class V1 extends Version
{
    protected $_flows;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'v1';
    }

    protected function getFlows(): FlowList
    {
        if (!$this->_flows) {
            $this->_flows = new FlowList($this);
        }
        return $this->_flows;
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new TwilioException('Unknown resource ' . $name);
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
        return '[Twilio.Studio.V1]';
    }
}