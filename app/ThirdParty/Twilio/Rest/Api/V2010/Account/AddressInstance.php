<?php

namespace Twilio\Rest\Api\V2010\Account;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Api\V2010\Account\Address\DependentPhoneNumberList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class AddressInstance extends InstanceResource
{
    protected $_dependentPhoneNumbers;

    public function __construct(Version $version, array $payload, string $accountSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'city' => Values::array_get($payload, 'city'), 'customerName' => Values::array_get($payload, 'customer_name'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'isoCountry' => Values::array_get($payload, 'iso_country'), 'postalCode' => Values::array_get($payload, 'postal_code'), 'region' => Values::array_get($payload, 'region'), 'sid' => Values::array_get($payload, 'sid'), 'street' => Values::array_get($payload, 'street'), 'uri' => Values::array_get($payload, 'uri'), 'emergencyEnabled' => Values::array_get($payload, 'emergency_enabled'), 'validated' => Values::array_get($payload, 'validated'), 'verified' => Values::array_get($payload, 'verified'),];
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function proxy(): AddressContext
    {
        if (!$this->context) {
            $this->context = new AddressContext($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): AddressInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): AddressInstance
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
        return '[Twilio.Api.V2010.AddressInstance ' . implode(' ', $context) . ']';
    }

    protected function getDependentPhoneNumbers(): DependentPhoneNumberList
    {
        return $this->proxy()->dependentPhoneNumbers;
    }
}