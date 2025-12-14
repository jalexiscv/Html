<?php

namespace Twilio\Rest\Voice\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Voice\V1\DialingPermissions\BulkCountryUpdateList;
use Twilio\Rest\Voice\V1\DialingPermissions\CountryContext;
use Twilio\Rest\Voice\V1\DialingPermissions\CountryList;
use Twilio\Rest\Voice\V1\DialingPermissions\SettingsContext;
use Twilio\Rest\Voice\V1\DialingPermissions\SettingsList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function property_exists;
use function ucfirst;

class DialingPermissionsList extends ListResource
{
    protected $_countries = null;
    protected $_settings = null;
    protected $_bulkCountryUpdates = null;

    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    protected function getCountries(): CountryList
    {
        if (!$this->_countries) {
            $this->_countries = new CountryList($this->version);
        }
        return $this->_countries;
    }

    protected function getSettings(): SettingsList
    {
        if (!$this->_settings) {
            $this->_settings = new SettingsList($this->version);
        }
        return $this->_settings;
    }

    protected function getBulkCountryUpdates(): BulkCountryUpdateList
    {
        if (!$this->_bulkCountryUpdates) {
            $this->_bulkCountryUpdates = new BulkCountryUpdateList($this->version);
        }
        return $this->_bulkCountryUpdates;
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
        return '[Twilio.Voice.V1.DialingPermissionsList]';
    }
}