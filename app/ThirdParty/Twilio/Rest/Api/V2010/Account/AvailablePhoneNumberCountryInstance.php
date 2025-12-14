<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry\LocalList;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry\MachineToMachineList;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry\MobileList;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry\NationalList;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry\SharedCostList;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry\TollFreeList;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry\VoipList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class AvailablePhoneNumberCountryInstance extends InstanceResource
{
    protected $_local;
    protected $_tollFree;
    protected $_mobile;
    protected $_national;
    protected $_voip;
    protected $_sharedCost;
    protected $_machineToMachine;

    public function __construct(Version $version, array $payload, string $accountSid, string $countryCode = null)
    {
        parent::__construct($version);
        $this->properties = ['countryCode' => Values::array_get($payload, 'country_code'), 'country' => Values::array_get($payload, 'country'), 'uri' => Values::array_get($payload, 'uri'), 'beta' => Values::array_get($payload, 'beta'), 'subresourceUris' => Values::array_get($payload, 'subresource_uris'),];
        $this->solution = ['accountSid' => $accountSid, 'countryCode' => $countryCode ?: $this->properties['countryCode'],];
    }

    protected function proxy(): AvailablePhoneNumberCountryContext
    {
        if (!$this->context) {
            $this->context = new AvailablePhoneNumberCountryContext($this->version, $this->solution['accountSid'], $this->solution['countryCode']);
        }
        return $this->context;
    }

    public function fetch(): AvailablePhoneNumberCountryInstance
    {
        return $this->proxy()->fetch();
    }

    protected function getLocal(): LocalList
    {
        return $this->proxy()->local;
    }

    protected function getTollFree(): TollFreeList
    {
        return $this->proxy()->tollFree;
    }

    protected function getMobile(): MobileList
    {
        return $this->proxy()->mobile;
    }

    protected function getNational(): NationalList
    {
        return $this->proxy()->national;
    }

    protected function getVoip(): VoipList
    {
        return $this->proxy()->voip;
    }

    protected function getSharedCost(): SharedCostList
    {
        return $this->proxy()->sharedCost;
    }

    protected function getMachineToMachine(): MachineToMachineList
    {
        return $this->proxy()->machineToMachine;
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
        return '[Twilio.Api.V2010.AvailablePhoneNumberCountryInstance ' . implode(' ', $context) . ']';
    }
}