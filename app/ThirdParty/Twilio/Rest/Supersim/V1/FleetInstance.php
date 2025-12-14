<?php

namespace Twilio\Rest\Supersim\V1;

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

class FleetInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'sid' => Values::array_get($payload, 'sid'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'dataEnabled' => Values::array_get($payload, 'data_enabled'), 'dataLimit' => Values::array_get($payload, 'data_limit'), 'dataMetering' => Values::array_get($payload, 'data_metering'), 'commandsEnabled' => Values::array_get($payload, 'commands_enabled'), 'commandsUrl' => Values::array_get($payload, 'commands_url'), 'commandsMethod' => Values::array_get($payload, 'commands_method'), 'networkAccessProfileSid' => Values::array_get($payload, 'network_access_profile_sid'),];
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

    public function update(array $options = []): FleetInstance
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
        return '[Twilio.Supersim.V1.FleetInstance ' . implode(' ', $context) . ']';
    }
}