<?php

namespace Twilio\Rest\Serverless\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Serverless\V1\Service\TwilioFunction\FunctionVersionContext;
use Twilio\Rest\Serverless\V1\Service\TwilioFunction\FunctionVersionList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class FunctionContext extends InstanceContext
{
    protected $_functionVersions;

    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Functions/' . rawurlencode($sid) . '';
    }

    public function fetch(): FunctionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new FunctionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(string $friendlyName): FunctionInstance
    {
        $data = Values::of(['FriendlyName' => $friendlyName,]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new FunctionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    protected function getFunctionVersions(): FunctionVersionList
    {
        if (!$this->_functionVersions) {
            $this->_functionVersions = new FunctionVersionList($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->_functionVersions;
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
        return '[Twilio.Serverless.V1.FunctionContext ' . implode(' ', $context) . ']';
    }
}