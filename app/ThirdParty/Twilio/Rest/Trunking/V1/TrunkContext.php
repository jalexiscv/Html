<?php

namespace Twilio\Rest\Trunking\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Trunking\V1\Trunk\CredentialListContext;
use Twilio\Rest\Trunking\V1\Trunk\CredentialListList;
use Twilio\Rest\Trunking\V1\Trunk\IpAccessControlListContext;
use Twilio\Rest\Trunking\V1\Trunk\IpAccessControlListList;
use Twilio\Rest\Trunking\V1\Trunk\OriginationUrlContext;
use Twilio\Rest\Trunking\V1\Trunk\OriginationUrlList;
use Twilio\Rest\Trunking\V1\Trunk\PhoneNumberContext;
use Twilio\Rest\Trunking\V1\Trunk\PhoneNumberList;
use Twilio\Rest\Trunking\V1\Trunk\RecordingContext;
use Twilio\Rest\Trunking\V1\Trunk\RecordingList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class TrunkContext extends InstanceContext
{
    protected $_originationUrls;
    protected $_credentialsLists;
    protected $_ipAccessControlLists;
    protected $_phoneNumbers;
    protected $_recordings;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Trunks/' . rawurlencode($sid) . '';
    }

    public function fetch(): TrunkInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new TrunkInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(array $options = []): TrunkInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'DomainName' => $options['domainName'], 'DisasterRecoveryUrl' => $options['disasterRecoveryUrl'], 'DisasterRecoveryMethod' => $options['disasterRecoveryMethod'], 'TransferMode' => $options['transferMode'], 'Secure' => Serialize::booleanToString($options['secure']), 'CnamLookupEnabled' => Serialize::booleanToString($options['cnamLookupEnabled']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new TrunkInstance($this->version, $payload, $this->solution['sid']);
    }

    protected function getOriginationUrls(): OriginationUrlList
    {
        if (!$this->_originationUrls) {
            $this->_originationUrls = new OriginationUrlList($this->version, $this->solution['sid']);
        }
        return $this->_originationUrls;
    }

    protected function getCredentialsLists(): CredentialListList
    {
        if (!$this->_credentialsLists) {
            $this->_credentialsLists = new CredentialListList($this->version, $this->solution['sid']);
        }
        return $this->_credentialsLists;
    }

    protected function getIpAccessControlLists(): IpAccessControlListList
    {
        if (!$this->_ipAccessControlLists) {
            $this->_ipAccessControlLists = new IpAccessControlListList($this->version, $this->solution['sid']);
        }
        return $this->_ipAccessControlLists;
    }

    protected function getPhoneNumbers(): PhoneNumberList
    {
        if (!$this->_phoneNumbers) {
            $this->_phoneNumbers = new PhoneNumberList($this->version, $this->solution['sid']);
        }
        return $this->_phoneNumbers;
    }

    protected function getRecordings(): RecordingList
    {
        if (!$this->_recordings) {
            $this->_recordings = new RecordingList($this->version, $this->solution['sid']);
        }
        return $this->_recordings;
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
        return '[Twilio.Trunking.V1.TrunkContext ' . implode(' ', $context) . ']';
    }
}