<?php

namespace Twilio\Rest\Preview\DeployedDevices;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Preview\DeployedDevices\Fleet\CertificateContext;
use Twilio\Rest\Preview\DeployedDevices\Fleet\CertificateList;
use Twilio\Rest\Preview\DeployedDevices\Fleet\DeploymentContext;
use Twilio\Rest\Preview\DeployedDevices\Fleet\DeploymentList;
use Twilio\Rest\Preview\DeployedDevices\Fleet\DeviceContext;
use Twilio\Rest\Preview\DeployedDevices\Fleet\DeviceList;
use Twilio\Rest\Preview\DeployedDevices\Fleet\KeyContext;
use Twilio\Rest\Preview\DeployedDevices\Fleet\KeyList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class FleetContext extends InstanceContext
{
    protected $_devices;
    protected $_deployments;
    protected $_certificates;
    protected $_keys;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Fleets/' . rawurlencode($sid) . '';
    }

    public function fetch(): FleetInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new FleetInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(array $options = []): FleetInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'DefaultDeploymentSid' => $options['defaultDeploymentSid'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new FleetInstance($this->version, $payload, $this->solution['sid']);
    }

    protected function getDevices(): DeviceList
    {
        if (!$this->_devices) {
            $this->_devices = new DeviceList($this->version, $this->solution['sid']);
        }
        return $this->_devices;
    }

    protected function getDeployments(): DeploymentList
    {
        if (!$this->_deployments) {
            $this->_deployments = new DeploymentList($this->version, $this->solution['sid']);
        }
        return $this->_deployments;
    }

    protected function getCertificates(): CertificateList
    {
        if (!$this->_certificates) {
            $this->_certificates = new CertificateList($this->version, $this->solution['sid']);
        }
        return $this->_certificates;
    }

    protected function getKeys(): KeyList
    {
        if (!$this->_keys) {
            $this->_keys = new KeyList($this->version, $this->solution['sid']);
        }
        return $this->_keys;
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
        return '[Twilio.Preview.DeployedDevices.FleetContext ' . implode(' ', $context) . ']';
    }
}