<?php

namespace Twilio\Rest\Preview\DeployedDevices\Fleet;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class DeviceInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $fleetSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'url' => Values::array_get($payload, 'url'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'fleetSid' => Values::array_get($payload, 'fleet_sid'), 'enabled' => Values::array_get($payload, 'enabled'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'identity' => Values::array_get($payload, 'identity'), 'deploymentSid' => Values::array_get($payload, 'deployment_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'dateAuthenticated' => Deserialize::dateTime(Values::array_get($payload, 'date_authenticated')),];
        $this->solution = ['fleetSid' => $fleetSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): DeviceContext
    {
        if (!$this->context) {
            $this->context = new DeviceContext($this->version, $this->solution['fleetSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): DeviceInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(array $options = []): DeviceInstance
    {
        return $this->proxy()->update($options);
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
        return '[Twilio.Preview.DeployedDevices.DeviceInstance ' . implode(' ', $context) . ']';
    }
}