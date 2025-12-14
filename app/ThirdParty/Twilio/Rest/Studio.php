<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Studio\V1;
use Twilio\Rest\Studio\V1\FlowContext;
use Twilio\Rest\Studio\V1\FlowList;
use Twilio\Rest\Studio\V2;
use Twilio\Rest\Studio\V2\FlowValidateList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class Studio extends Domain
{
    protected $_v1;
    protected $_v2;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://studio.twilio.com';
    }

    protected function getV1(): V1
    {
        if (!$this->_v1) {
            $this->_v1 = new V1($this);
        }
        return $this->_v1;
    }

    protected function getV2(): V2
    {
        if (!$this->_v2) {
            $this->_v2 = new V2($this);
        }
        return $this->_v2;
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new TwilioException('Unknown version ' . $name);
    }

    public function __call(string $name, array $arguments)
    {
        $method = 'context' . ucfirst($name);
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $arguments);
        }
        throw new TwilioException('Unknown context ' . $name);
    }

    protected function getFlows(): FlowList
    {
        return $this->v1->flows;
    }

    protected function contextFlows(string $sid): FlowContext
    {
        return $this->v1->flows($sid);
    }

    protected function getFlowValidate(): FlowValidateList
    {
        return $this->v2->flowValidate;
    }

    public function __toString(): string
    {
        return '[Twilio.Studio]';
    }
}