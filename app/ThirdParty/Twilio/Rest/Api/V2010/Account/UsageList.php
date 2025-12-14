<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Api\V2010\Account\Usage\RecordList;
use Twilio\Rest\Api\V2010\Account\Usage\TriggerContext;
use Twilio\Rest\Api\V2010\Account\Usage\TriggerList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function property_exists;
use function ucfirst;

class UsageList extends ListResource
{
    protected $_records = null;
    protected $_triggers = null;

    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
    }

    protected function getRecords(): RecordList
    {
        if (!$this->_records) {
            $this->_records = new RecordList($this->version, $this->solution['accountSid']);
        }
        return $this->_records;
    }

    protected function getTriggers(): TriggerList
    {
        if (!$this->_triggers) {
            $this->_triggers = new TriggerList($this->version, $this->solution['accountSid']);
        }
        return $this->_triggers;
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
        return '[Twilio.Api.V2010.UsageList]';
    }
}