<?php

namespace Twilio\Rest\Wireless\V1;

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

class RatePlanInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'dataEnabled' => Values::array_get($payload, 'data_enabled'), 'dataMetering' => Values::array_get($payload, 'data_metering'), 'dataLimit' => Values::array_get($payload, 'data_limit'), 'messagingEnabled' => Values::array_get($payload, 'messaging_enabled'), 'voiceEnabled' => Values::array_get($payload, 'voice_enabled'), 'nationalRoamingEnabled' => Values::array_get($payload, 'national_roaming_enabled'), 'nationalRoamingDataLimit' => Values::array_get($payload, 'national_roaming_data_limit'), 'internationalRoaming' => Values::array_get($payload, 'international_roaming'), 'internationalRoamingDataLimit' => Values::array_get($payload, 'international_roaming_data_limit'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): RatePlanContext
    {
        if (!$this->context) {
            $this->context = new RatePlanContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): RatePlanInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): RatePlanInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
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
        return '[Twilio.Wireless.V1.RatePlanInstance ' . implode(' ', $context) . ']';
    }
}