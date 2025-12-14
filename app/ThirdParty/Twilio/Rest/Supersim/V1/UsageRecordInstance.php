<?php

namespace Twilio\Rest\Supersim\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class UsageRecordInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'simSid' => Values::array_get($payload, 'sim_sid'), 'networkSid' => Values::array_get($payload, 'network_sid'), 'fleetSid' => Values::array_get($payload, 'fleet_sid'), 'isoCountry' => Values::array_get($payload, 'iso_country'), 'period' => Values::array_get($payload, 'period'), 'dataUpload' => Values::array_get($payload, 'data_upload'), 'dataDownload' => Values::array_get($payload, 'data_download'), 'dataTotal' => Values::array_get($payload, 'data_total'),];
        $this->solution = [];
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
        return '[Twilio.Supersim.V1.UsageRecordInstance]';
    }
}