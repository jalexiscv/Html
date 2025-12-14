<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Voice\V1;
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

class Voice extends Domain
{
    protected $_v1;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://voice.twilio.com';
    }

    protected function getV1(): V1
    {
        if (!$this->_v1) {
            $this->_v1 = new V1($this);
        }
        return $this->_v1;
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new TwilioException('Unknown version ' . $name);
    }

    public function __call(string $name, array $arguments)
    {
        $method = 'context' . ucfirst($name);
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $arguments);
        }
        throw new TwilioException('Unknown context ' . $name);
    }

    protected function getByocTrunks(): ByocTrunkList
    {
        return $this->v1->byocTrunks;
    }

    protected function contextByocTrunks(string $sid): ByocTrunkContext
    {
        return $this->v1->byocTrunks($sid);
    }

    protected function getConnectionPolicies(): ConnectionPolicyList
    {
        return $this->v1->connectionPolicies;
    }

    protected function contextConnectionPolicies(string $sid): ConnectionPolicyContext
    {
        return $this->v1->connectionPolicies($sid);
    }

    protected function getDialingPermissions(): DialingPermissionsList
    {
        return $this->v1->dialingPermissions;
    }

    protected function getIpRecords(): IpRecordList
    {
        return $this->v1->ipRecords;
    }

    protected function contextIpRecords(string $sid): IpRecordContext
    {
        return $this->v1->ipRecords($sid);
    }

    protected function getSourceIpMappings(): SourceIpMappingList
    {
        return $this->v1->sourceIpMappings;
    }

    protected function contextSourceIpMappings(string $sid): SourceIpMappingContext
    {
        return $this->v1->sourceIpMappings($sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Voice]';
    }
}