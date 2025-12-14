<?php

namespace Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class LocalOptions
{
    public static function read(int $areaCode = Values::NONE, string $contains = Values::NONE, bool $smsEnabled = Values::NONE, bool $mmsEnabled = Values::NONE, bool $voiceEnabled = Values::NONE, bool $excludeAllAddressRequired = Values::NONE, bool $excludeLocalAddressRequired = Values::NONE, bool $excludeForeignAddressRequired = Values::NONE, bool $beta = Values::NONE, string $nearNumber = Values::NONE, string $nearLatLong = Values::NONE, int $distance = Values::NONE, string $inPostalCode = Values::NONE, string $inRegion = Values::NONE, string $inRateCenter = Values::NONE, string $inLata = Values::NONE, string $inLocality = Values::NONE, bool $faxEnabled = Values::NONE): ReadLocalOptions
    {
        return new ReadLocalOptions($areaCode, $contains, $smsEnabled, $mmsEnabled, $voiceEnabled, $excludeAllAddressRequired, $excludeLocalAddressRequired, $excludeForeignAddressRequired, $beta, $nearNumber, $nearLatLong, $distance, $inPostalCode, $inRegion, $inRateCenter, $inLata, $inLocality, $faxEnabled);
    }
}

class ReadLocalOptions extends Options
{
    public function __construct(int $areaCode = Values::NONE, string $contains = Values::NONE, bool $smsEnabled = Values::NONE, bool $mmsEnabled = Values::NONE, bool $voiceEnabled = Values::NONE, bool $excludeAllAddressRequired = Values::NONE, bool $excludeLocalAddressRequired = Values::NONE, bool $excludeForeignAddressRequired = Values::NONE, bool $beta = Values::NONE, string $nearNumber = Values::NONE, string $nearLatLong = Values::NONE, int $distance = Values::NONE, string $inPostalCode = Values::NONE, string $inRegion = Values::NONE, string $inRateCenter = Values::NONE, string $inLata = Values::NONE, string $inLocality = Values::NONE, bool $faxEnabled = Values::NONE)
    {
        $this->options['areaCode'] = $areaCode;
        $this->options['contains'] = $contains;
        $this->options['smsEnabled'] = $smsEnabled;
        $this->options['mmsEnabled'] = $mmsEnabled;
        $this->options['voiceEnabled'] = $voiceEnabled;
        $this->options['excludeAllAddressRequired'] = $excludeAllAddressRequired;
        $this->options['excludeLocalAddressRequired'] = $excludeLocalAddressRequired;
        $this->options['excludeForeignAddressRequired'] = $excludeForeignAddressRequired;
        $this->options['beta'] = $beta;
        $this->options['nearNumber'] = $nearNumber;
        $this->options['nearLatLong'] = $nearLatLong;
        $this->options['distance'] = $distance;
        $this->options['inPostalCode'] = $inPostalCode;
        $this->options['inRegion'] = $inRegion;
        $this->options['inRateCenter'] = $inRateCenter;
        $this->options['inLata'] = $inLata;
        $this->options['inLocality'] = $inLocality;
        $this->options['faxEnabled'] = $faxEnabled;
    }

    public function setAreaCode(int $areaCode): self
    {
        $this->options['areaCode'] = $areaCode;
        return $this;
    }

    public function setContains(string $contains): self
    {
        $this->options['contains'] = $contains;
        return $this;
    }

    public function setSmsEnabled(bool $smsEnabled): self
    {
        $this->options['smsEnabled'] = $smsEnabled;
        return $this;
    }

    public function setMmsEnabled(bool $mmsEnabled): self
    {
        $this->options['mmsEnabled'] = $mmsEnabled;
        return $this;
    }

    public function setVoiceEnabled(bool $voiceEnabled): self
    {
        $this->options['voiceEnabled'] = $voiceEnabled;
        return $this;
    }

    public function setExcludeAllAddressRequired(bool $excludeAllAddressRequired): self
    {
        $this->options['excludeAllAddressRequired'] = $excludeAllAddressRequired;
        return $this;
    }

    public function setExcludeLocalAddressRequired(bool $excludeLocalAddressRequired): self
    {
        $this->options['excludeLocalAddressRequired'] = $excludeLocalAddressRequired;
        return $this;
    }

    public function setExcludeForeignAddressRequired(bool $excludeForeignAddressRequired): self
    {
        $this->options['excludeForeignAddressRequired'] = $excludeForeignAddressRequired;
        return $this;
    }

    public function setBeta(bool $beta): self
    {
        $this->options['beta'] = $beta;
        return $this;
    }

    public function setNearNumber(string $nearNumber): self
    {
        $this->options['nearNumber'] = $nearNumber;
        return $this;
    }

    public function setNearLatLong(string $nearLatLong): self
    {
        $this->options['nearLatLong'] = $nearLatLong;
        return $this;
    }

    public function setDistance(int $distance): self
    {
        $this->options['distance'] = $distance;
        return $this;
    }

    public function setInPostalCode(string $inPostalCode): self
    {
        $this->options['inPostalCode'] = $inPostalCode;
        return $this;
    }

    public function setInRegion(string $inRegion): self
    {
        $this->options['inRegion'] = $inRegion;
        return $this;
    }

    public function setInRateCenter(string $inRateCenter): self
    {
        $this->options['inRateCenter'] = $inRateCenter;
        return $this;
    }

    public function setInLata(string $inLata): self
    {
        $this->options['inLata'] = $inLata;
        return $this;
    }

    public function setInLocality(string $inLocality): self
    {
        $this->options['inLocality'] = $inLocality;
        return $this;
    }

    public function setFaxEnabled(bool $faxEnabled): self
    {
        $this->options['faxEnabled'] = $faxEnabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.ReadLocalOptions ' . $options . ']';
    }
}