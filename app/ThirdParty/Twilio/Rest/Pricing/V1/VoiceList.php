<?php

namespace Twilio\Rest\Pricing\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Pricing\V1\Voice\CountryContext;
use Twilio\Rest\Pricing\V1\Voice\CountryList;
use Twilio\Rest\Pricing\V1\Voice\NumberContext;
use Twilio\Rest\Pricing\V1\Voice\NumberList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function property_exists;
use function ucfirst;

class VoiceList extends ListResource
{
    protected $_numbers = null;
    protected $_countries = null;

    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    protected function getNumbers(): NumberList
    {
        if (!$this->_numbers) {
            $this->_numbers = new NumberList($this->version);
        }
        return $this->_numbers;
    }

    protected function getCountries(): CountryList
    {
        if (!$this->_countries) {
            $this->_countries = new CountryList($this->version);
        }
        return $this->_countries;
    }

    public function __get(string $name)
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
        return '[Twilio.Pricing.V1.VoiceList]';
    }
}