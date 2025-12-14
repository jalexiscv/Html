<?php

namespace Twilio\Rest\Voice\V1\DialingPermissions;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class CountryOptions
{
    public static function read(string $isoCode = Values::NONE, string $continent = Values::NONE, string $countryCode = Values::NONE, bool $lowRiskNumbersEnabled = Values::NONE, bool $highRiskSpecialNumbersEnabled = Values::NONE, bool $highRiskTollfraudNumbersEnabled = Values::NONE): ReadCountryOptions
    {
        return new ReadCountryOptions($isoCode, $continent, $countryCode, $lowRiskNumbersEnabled, $highRiskSpecialNumbersEnabled, $highRiskTollfraudNumbersEnabled);
    }
}

class ReadCountryOptions extends Options
{
    public function __construct(string $isoCode = Values::NONE, string $continent = Values::NONE, string $countryCode = Values::NONE, bool $lowRiskNumbersEnabled = Values::NONE, bool $highRiskSpecialNumbersEnabled = Values::NONE, bool $highRiskTollfraudNumbersEnabled = Values::NONE)
    {
        $this->options['isoCode'] = $isoCode;
        $this->options['continent'] = $continent;
        $this->options['countryCode'] = $countryCode;
        $this->options['lowRiskNumbersEnabled'] = $lowRiskNumbersEnabled;
        $this->options['highRiskSpecialNumbersEnabled'] = $highRiskSpecialNumbersEnabled;
        $this->options['highRiskTollfraudNumbersEnabled'] = $highRiskTollfraudNumbersEnabled;
    }

    public function setIsoCode(string $isoCode): self
    {
        $this->options['isoCode'] = $isoCode;
        return $this;
    }

    public function setContinent(string $continent): self
    {
        $this->options['continent'] = $continent;
        return $this;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->options['countryCode'] = $countryCode;
        return $this;
    }

    public function setLowRiskNumbersEnabled(bool $lowRiskNumbersEnabled): self
    {
        $this->options['lowRiskNumbersEnabled'] = $lowRiskNumbersEnabled;
        return $this;
    }

    public function setHighRiskSpecialNumbersEnabled(bool $highRiskSpecialNumbersEnabled): self
    {
        $this->options['highRiskSpecialNumbersEnabled'] = $highRiskSpecialNumbersEnabled;
        return $this;
    }

    public function setHighRiskTollfraudNumbersEnabled(bool $highRiskTollfraudNumbersEnabled): self
    {
        $this->options['highRiskTollfraudNumbersEnabled'] = $highRiskTollfraudNumbersEnabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Voice.V1.ReadCountryOptions ' . $options . ']';
    }
}