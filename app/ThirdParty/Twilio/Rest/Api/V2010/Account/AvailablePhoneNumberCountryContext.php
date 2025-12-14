<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry\LocalList;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry\MachineToMachineList;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry\MobileList;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry\NationalList;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry\SharedCostList;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry\TollFreeList;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry\VoipList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class AvailablePhoneNumberCountryContext extends InstanceContext
{
    protected $_local;
    protected $_tollFree;
    protected $_mobile;
    protected $_national;
    protected $_voip;
    protected $_sharedCost;
    protected $_machineToMachine;

    public function __construct(Version $version, $accountSid, $countryCode)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'countryCode' => $countryCode,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/AvailablePhoneNumbers/' . rawurlencode($countryCode) . '.json';
    }

    public function fetch(): AvailablePhoneNumberCountryInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new AvailablePhoneNumberCountryInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['countryCode']);
    }

    protected function getLocal(): LocalList
    {
        if (!$this->_local) {
            $this->_local = new LocalList($this->version, $this->solution['accountSid'], $this->solution['countryCode']);
        }
        return $this->_local;
    }

    protected function getTollFree(): TollFreeList
    {
        if (!$this->_tollFree) {
            $this->_tollFree = new TollFreeList($this->version, $this->solution['accountSid'], $this->solution['countryCode']);
        }
        return $this->_tollFree;
    }

    protected function getMobile(): MobileList
    {
        if (!$this->_mobile) {
            $this->_mobile = new MobileList($this->version, $this->solution['accountSid'], $this->solution['countryCode']);
        }
        return $this->_mobile;
    }

    protected function getNational(): NationalList
    {
        if (!$this->_national) {
            $this->_national = new NationalList($this->version, $this->solution['accountSid'], $this->solution['countryCode']);
        }
        return $this->_national;
    }

    protected function getVoip(): VoipList
    {
        if (!$this->_voip) {
            $this->_voip = new VoipList($this->version, $this->solution['accountSid'], $this->solution['countryCode']);
        }
        return $this->_voip;
    }

    protected function getSharedCost(): SharedCostList
    {
        if (!$this->_sharedCost) {
            $this->_sharedCost = new SharedCostList($this->version, $this->solution['accountSid'], $this->solution['countryCode']);
        }
        return $this->_sharedCost;
    }

    protected function getMachineToMachine(): MachineToMachineList
    {
        if (!$this->_machineToMachine) {
            $this->_machineToMachine = new MachineToMachineList($this->version, $this->solution['accountSid'], $this->solution['countryCode']);
        }
        return $this->_machineToMachine;
    }

    public function __get(string $name): ListResource
    {
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown subresource ' . $name);
    }

    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }
        throw new TwilioException('Resource does not have a context');
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.AvailablePhoneNumberCountryContext ' . implode(' ', $context) . ']';
    }
}