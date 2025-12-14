<?php

namespace Twilio\Rest\Api\V2010\Account\Usage;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class RecordInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'apiVersion' => Values::array_get($payload, 'api_version'), 'asOf' => Values::array_get($payload, 'as_of'), 'category' => Values::array_get($payload, 'category'), 'count' => Values::array_get($payload, 'count'), 'countUnit' => Values::array_get($payload, 'count_unit'), 'description' => Values::array_get($payload, 'description'), 'endDate' => Deserialize::dateTime(Values::array_get($payload, 'end_date')), 'price' => Values::array_get($payload, 'price'), 'priceUnit' => Values::array_get($payload, 'price_unit'), 'startDate' => Deserialize::dateTime(Values::array_get($payload, 'start_date')), 'subresourceUris' => Values::array_get($payload, 'subresource_uris'), 'uri' => Values::array_get($payload, 'uri'), 'usage' => Values::array_get($payload, 'usage'), 'usageUnit' => Values::array_get($payload, 'usage_unit'),];
        $this->solution = ['accountSid' => $accountSid,];
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
        return '[Twilio.Api.V2010.RecordInstance]';
    }
}