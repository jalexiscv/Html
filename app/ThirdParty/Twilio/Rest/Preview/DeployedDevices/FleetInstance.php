<?php

namespace Twilio\Rest\Preview\DeployedDevices;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Preview\DeployedDevices\Fleet\CertificateList;
use Twilio\Rest\Preview\DeployedDevices\Fleet\DeploymentList;
use Twilio\Rest\Preview\DeployedDevices\Fleet\DeviceList;
use Twilio\Rest\Preview\DeployedDevices\Fleet\KeyList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class FleetInstance extends InstanceResource
{
    protected $_devices;
    protected $_deployments;
    protected $_certificates;
    protected $_keys;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'url' => Values::array_get($payload, 'url'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'defaultDeploymentSid' => Values::array_get($payload, 'default_deployment_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): FleetContext
    {
        if (!$this->context) {
            $this->context = new FleetContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): FleetInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(array $options = []): FleetInstance
    {
        return $this->proxy()->update($options);
    }

    protected function getDevices(): DeviceList
    {
        return $this->proxy()->devices;
    }

    protected function getDeployments(): DeploymentList
    {
        return $this->proxy()->deployments;
    }

    protected function getCertificates(): CertificateList
    {
        return $this->proxy()->certificates;
    }

    protected function getKeys(): KeyList
    {
        return $this->proxy()->keys;
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown property: ' . $name);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.DeployedDevices.FleetInstance ' . implode(' ', $context) . ']';
    }
}