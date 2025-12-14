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

class DeploymentInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $fleetSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'url' => Values::array_get($payload, 'url'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'fleetSid' => Values::array_get($payload, 'fleet_sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'syncServiceSid' => Values::array_get($payload, 'sync_service_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),];
        $this->solution = ['fleetSid' => $fleetSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): DeploymentContext
    {
        if (!$this->context) {
            $this->context = new DeploymentContext($this->version, $this->solution['fleetSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): DeploymentInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(array $options = []): DeploymentInstance
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
        return '[Twilio.Preview.DeployedDevices.DeploymentInstance ' . implode(' ', $context) . ']';
    }
}