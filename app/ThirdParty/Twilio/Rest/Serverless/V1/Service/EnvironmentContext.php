<?php

namespace Twilio\Rest\Serverless\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Serverless\V1\Service\Environment\DeploymentContext;
use Twilio\Rest\Serverless\V1\Service\Environment\DeploymentList;
use Twilio\Rest\Serverless\V1\Service\Environment\LogContext;
use Twilio\Rest\Serverless\V1\Service\Environment\LogList;
use Twilio\Rest\Serverless\V1\Service\Environment\VariableContext;
use Twilio\Rest\Serverless\V1\Service\Environment\VariableList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class EnvironmentContext extends InstanceContext
{
    protected $_variables;
    protected $_deployments;
    protected $_logs;

    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Environments/' . rawurlencode($sid) . '';
    }

    public function fetch(): EnvironmentInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new EnvironmentInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getVariables(): VariableList
    {
        if (!$this->_variables) {
            $this->_variables = new VariableList($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->_variables;
    }

    protected function getDeployments(): DeploymentList
    {
        if (!$this->_deployments) {
            $this->_deployments = new DeploymentList($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->_deployments;
    }

    protected function getLogs(): LogList
    {
        if (!$this->_logs) {
            $this->_logs = new LogList($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->_logs;
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
        return '[Twilio.Serverless.V1.EnvironmentContext ' . implode(' ', $context) . ']';
    }
}