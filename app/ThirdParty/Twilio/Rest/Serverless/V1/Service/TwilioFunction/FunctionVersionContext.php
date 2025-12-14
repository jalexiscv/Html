<?php

namespace Twilio\Rest\Serverless\V1\Service\TwilioFunction;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Serverless\V1\Service\TwilioFunction\FunctionVersion\FunctionVersionContentContext;
use Twilio\Rest\Serverless\V1\Service\TwilioFunction\FunctionVersion\FunctionVersionContentList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class FunctionVersionContext extends InstanceContext
{
    protected $_functionVersionContent;

    public function __construct(Version $version, $serviceSid, $functionSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'functionSid' => $functionSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Functions/' . rawurlencode($functionSid) . '/Versions/' . rawurlencode($sid) . '';
    }

    public function fetch(): FunctionVersionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new FunctionVersionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['functionSid'], $this->solution['sid']);
    }

    protected function getFunctionVersionContent(): FunctionVersionContentList
    {
        if (!$this->_functionVersionContent) {
            $this->_functionVersionContent = new FunctionVersionContentList($this->version, $this->solution['serviceSid'], $this->solution['functionSid'], $this->solution['sid']);
        }
        return $this->_functionVersionContent;
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
        return '[Twilio.Serverless.V1.FunctionVersionContext ' . implode(' ', $context) . ']';
    }
}