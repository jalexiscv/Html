<?php

namespace Twilio\Rest\Voice\V1\DialingPermissions;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Voice\V1\DialingPermissions\Country\HighriskSpecialPrefixList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class CountryInstance extends InstanceResource
{
    protected $_highriskSpecialPrefixes;

    public function __construct(Version $version, array $payload, string $isoCode = null)
    {
        parent::__construct($version);
        $this->properties = ['isoCode' => Values::array_get($payload, 'iso_code'), 'name' => Values::array_get($payload, 'name'), 'continent' => Values::array_get($payload, 'continent'), 'countryCodes' => Values::array_get($payload, 'country_codes'), 'lowRiskNumbersEnabled' => Values::array_get($payload, 'low_risk_numbers_enabled'), 'highRiskSpecialNumbersEnabled' => Values::array_get($payload, 'high_risk_special_numbers_enabled'), 'highRiskTollfraudNumbersEnabled' => Values::array_get($payload, 'high_risk_tollfraud_numbers_enabled'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['isoCode' => $isoCode ?: $this->properties['isoCode'],];
    }

    protected function proxy(): CountryContext
    {
        if (!$this->context) {
            $this->context = new CountryContext($this->version, $this->solution['isoCode']);
        }
        return $this->context;
    }

    public function fetch(): CountryInstance
    {
        return $this->proxy()->fetch();
    }

    protected function getHighriskSpecialPrefixes(): HighriskSpecialPrefixList
    {
        return $this->proxy()->highriskSpecialPrefixes;
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
        return '[Twilio.Voice.V1.CountryInstance ' . implode(' ', $context) . ']';
    }
}