<?php

namespace Twilio\Rest\Serverless\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Serverless\V1\Service\AssetContext;
use Twilio\Rest\Serverless\V1\Service\AssetList;
use Twilio\Rest\Serverless\V1\Service\BuildContext;
use Twilio\Rest\Serverless\V1\Service\BuildList;
use Twilio\Rest\Serverless\V1\Service\EnvironmentContext;
use Twilio\Rest\Serverless\V1\Service\EnvironmentList;
use Twilio\Rest\Serverless\V1\Service\FunctionContext;
use Twilio\Rest\Serverless\V1\Service\FunctionList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class ServiceContext extends InstanceContext
{
    protected $_environments;
    protected $_functions;
    protected $_assets;
    protected $_builds;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($sid) . '';
    }

    public function fetch(): ServiceInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ServiceInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(array $options = []): ServiceInstance
    {
        $options = new Values($options);
        $data = Values::of(['IncludeCredentials' => Serialize::booleanToString($options['includeCredentials']), 'FriendlyName' => $options['friendlyName'], 'UiEditable' => Serialize::booleanToString($options['uiEditable']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ServiceInstance($this->version, $payload, $this->solution['sid']);
    }

    protected function getEnvironments(): EnvironmentList
    {
        if (!$this->_environments) {
            $this->_environments = new EnvironmentList($this->version, $this->solution['sid']);
        }
        return $this->_environments;
    }

    protected function getFunctions(): FunctionList
    {
        if (!$this->_functions) {
            $this->_functions = new FunctionList($this->version, $this->solution['sid']);
        }
        return $this->_functions;
    }

    protected function getAssets(): AssetList
    {
        if (!$this->_assets) {
            $this->_assets = new AssetList($this->version, $this->solution['sid']);
        }
        return $this->_assets;
    }

    protected function getBuilds(): BuildList
    {
        if (!$this->_builds) {
            $this->_builds = new BuildList($this->version, $this->solution['sid']);
        }
        return $this->_builds;
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
        return '[Twilio.Serverless.V1.ServiceContext ' . implode(' ', $context) . ']';
    }
}