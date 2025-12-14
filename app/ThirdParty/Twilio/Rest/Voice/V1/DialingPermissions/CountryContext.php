<?php

namespace Twilio\Rest\Voice\V1\DialingPermissions;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Voice\V1\DialingPermissions\Country\HighriskSpecialPrefixList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class CountryContext extends InstanceContext
{
    protected $_highriskSpecialPrefixes;

    public function __construct(Version $version, $isoCode)
    {
        parent::__construct($version);
        $this->solution = ['isoCode' => $isoCode,];
        $this->uri = '/DialingPermissions/Countries/' . rawurlencode($isoCode) . '';
    }

    public function fetch(): CountryInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new CountryInstance($this->version, $payload, $this->solution['isoCode']);
    }

    protected function getHighriskSpecialPrefixes(): HighriskSpecialPrefixList
    {
        if (!$this->_highriskSpecialPrefixes) {
            $this->_highriskSpecialPrefixes = new HighriskSpecialPrefixList($this->version, $this->solution['isoCode']);
        }
        return $this->_highriskSpecialPrefixes;
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
        return '[Twilio.Voice.V1.CountryContext ' . implode(' ', $context) . ']';
    }
}