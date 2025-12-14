<?php

namespace Twilio\Rest\Voice;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Voice\V1\ByocTrunkContext;
use Twilio\Rest\Voice\V1\ByocTrunkList;
use Twilio\Rest\Voice\V1\ConnectionPolicyContext;
use Twilio\Rest\Voice\V1\ConnectionPolicyList;
use Twilio\Rest\Voice\V1\DialingPermissionsList;
use Twilio\Rest\Voice\V1\IpRecordContext;
use Twilio\Rest\Voice\V1\IpRecordList;
use Twilio\Rest\Voice\V1\SourceIpMappingContext;
use Twilio\Rest\Voice\V1\SourceIpMappingList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class V1 extends Version
{
    protected $_byocTrunks;
    protected $_connectionPolicies;
    protected $_dialingPermissions;
    protected $_ipRecords;
    protected $_sourceIpMappings;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'v1';
    }

    protected function getByocTrunks(): ByocTrunkList
    {
        if (!$this->_byocTrunks) {
            $this->_byocTrunks = new ByocTrunkList($this);
        }
        return $this->_byocTrunks;
    }

    protected function getConnectionPolicies(): ConnectionPolicyList
    {
        if (!$this->_connectionPolicies) {
            $this->_connectionPolicies = new ConnectionPolicyList($this);
        }
        return $this->_connectionPolicies;
    }

    protected function getDialingPermissions(): DialingPermissionsList
    {
        if (!$this->_dialingPermissions) {
            $this->_dialingPermissions = new DialingPermissionsList($this);
        }
        return $this->_dialingPermissions;
    }

    protected function getIpRecords(): IpRecordList
    {
        if (!$this->_ipRecords) {
            $this->_ipRecords = new IpRecordList($this);
        }
        return $this->_ipRecords;
    }

    protected function getSourceIpMappings(): SourceIpMappingList
    {
        if (!$this->_sourceIpMappings) {
            $this->_sourceIpMappings = new SourceIpMappingList($this);
        }
        return $this->_sourceIpMappings;
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new TwilioException('Unknown resource ' . $name);
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
        return '[Twilio.Voice.V1]';
    }
}