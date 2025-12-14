<?php

namespace Twilio\Rest\Wireless\V1\Sim;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class DataSessionInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $simSid)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'simSid' => Values::array_get($payload, 'sim_sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'radioLink' => Values::array_get($payload, 'radio_link'), 'operatorMcc' => Values::array_get($payload, 'operator_mcc'), 'operatorMnc' => Values::array_get($payload, 'operator_mnc'), 'operatorCountry' => Values::array_get($payload, 'operator_country'), 'operatorName' => Values::array_get($payload, 'operator_name'), 'cellId' => Values::array_get($payload, 'cell_id'), 'cellLocationEstimate' => Values::array_get($payload, 'cell_location_estimate'), 'packetsUploaded' => Values::array_get($payload, 'packets_uploaded'), 'packetsDownloaded' => Values::array_get($payload, 'packets_downloaded'), 'lastUpdated' => Deserialize::dateTime(Values::array_get($payload, 'last_updated')), 'start' => Deserialize::dateTime(Values::array_get($payload, 'start')), 'end' => Deserialize::dateTime(Values::array_get($payload, 'end')), 'imei' => Values::array_get($payload, 'imei'),];
        $this->solution = ['simSid' => $simSid,];
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
        return '[Twilio.Wireless.V1.DataSessionInstance]';
    }
}