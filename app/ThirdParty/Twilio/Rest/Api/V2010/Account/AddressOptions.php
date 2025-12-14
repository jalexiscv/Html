<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class AddressOptions
{
    public static function create(string $friendlyName = Values::NONE, bool $emergencyEnabled = Values::NONE, bool $autoCorrectAddress = Values::NONE): CreateAddressOptions
    {
        return new CreateAddressOptions($friendlyName, $emergencyEnabled, $autoCorrectAddress);
    }

    public static function update(string $friendlyName = Values::NONE, string $customerName = Values::NONE, string $street = Values::NONE, string $city = Values::NONE, string $region = Values::NONE, string $postalCode = Values::NONE, bool $emergencyEnabled = Values::NONE, bool $autoCorrectAddress = Values::NONE): UpdateAddressOptions
    {
        return new UpdateAddressOptions($friendlyName, $customerName, $street, $city, $region, $postalCode, $emergencyEnabled, $autoCorrectAddress);
    }

    public static function read(string $customerName = Values::NONE, string $friendlyName = Values::NONE, string $isoCountry = Values::NONE): ReadAddressOptions
    {
        return new ReadAddressOptions($customerName, $friendlyName, $isoCountry);
    }
}

class CreateAddressOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, bool $emergencyEnabled = Values::NONE, bool $autoCorrectAddress = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['emergencyEnabled'] = $emergencyEnabled;
        $this->options['autoCorrectAddress'] = $autoCorrectAddress;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setEmergencyEnabled(bool $emergencyEnabled): self
    {
        $this->options['emergencyEnabled'] = $emergencyEnabled;
        return $this;
    }

    public function setAutoCorrectAddress(bool $autoCorrectAddress): self
    {
        $this->options['autoCorrectAddress'] = $autoCorrectAddress;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.CreateAddressOptions ' . $options . ']';
    }
}

class UpdateAddressOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $customerName = Values::NONE, string $street = Values::NONE, string $city = Values::NONE, string $region = Values::NONE, string $postalCode = Values::NONE, bool $emergencyEnabled = Values::NONE, bool $autoCorrectAddress = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['customerName'] = $customerName;
        $this->options['street'] = $street;
        $this->options['city'] = $city;
        $this->options['region'] = $region;
        $this->options['postalCode'] = $postalCode;
        $this->options['emergencyEnabled'] = $emergencyEnabled;
        $this->options['autoCorrectAddress'] = $autoCorrectAddress;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setCustomerName(string $customerName): self
    {
        $this->options['customerName'] = $customerName;
        return $this;
    }

    public function setStreet(string $street): self
    {
        $this->options['street'] = $street;
        return $this;
    }

    public function setCity(string $city): self
    {
        $this->options['city'] = $city;
        return $this;
    }

    public function setRegion(string $region): self
    {
        $this->options['region'] = $region;
        return $this;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->options['postalCode'] = $postalCode;
        return $this;
    }

    public function setEmergencyEnabled(bool $emergencyEnabled): self
    {
        $this->options['emergencyEnabled'] = $emergencyEnabled;
        return $this;
    }

    public function setAutoCorrectAddress(bool $autoCorrectAddress): self
    {
        $this->options['autoCorrectAddress'] = $autoCorrectAddress;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.UpdateAddressOptions ' . $options . ']';
    }
}

class ReadAddressOptions extends Options
{
    public function __construct(string $customerName = Values::NONE, string $friendlyName = Values::NONE, string $isoCountry = Values::NONE)
    {
        $this->options['customerName'] = $customerName;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['isoCountry'] = $isoCountry;
    }

    public function setCustomerName(string $customerName): self
    {
        $this->options['customerName'] = $customerName;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setIsoCountry(string $isoCountry): self
    {
        $this->options['isoCountry'] = $isoCountry;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.ReadAddressOptions ' . $options . ']';
    }
}