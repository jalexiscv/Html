<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\LocalList;
use Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\MobileList;
use Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\TollFreeList;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function iterator_to_array;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class IncomingPhoneNumberList extends ListResource
{
    protected $_local = null;
    protected $_mobile = null;
    protected $_tollFree = null;

    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/IncomingPhoneNumbers.json';
    }

    public function stream(array $options = [], int $limit = null, $pageSize = null): Stream
    {
        $limits = $this->version->readLimits($limit, $pageSize);
        $page = $this->page($options, $limits['pageSize']);
        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    public function read(array $options = [], int $limit = null, $pageSize = null): array
    {
        return iterator_to_array($this->stream($options, $limit, $pageSize), false);
    }

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): IncomingPhoneNumberPage
    {
        $options = new Values($options);
        $params = Values::of(['Beta' => Serialize::booleanToString($options['beta']), 'FriendlyName' => $options['friendlyName'], 'PhoneNumber' => $options['phoneNumber'], 'Origin' => $options['origin'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new IncomingPhoneNumberPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): IncomingPhoneNumberPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new IncomingPhoneNumberPage($this->version, $response, $this->solution);
    }

    public function create(array $options = []): IncomingPhoneNumberInstance
    {
        $options = new Values($options);
        $data = Values::of(['PhoneNumber' => $options['phoneNumber'], 'AreaCode' => $options['areaCode'], 'ApiVersion' => $options['apiVersion'], 'FriendlyName' => $options['friendlyName'], 'SmsApplicationSid' => $options['smsApplicationSid'], 'SmsFallbackMethod' => $options['smsFallbackMethod'], 'SmsFallbackUrl' => $options['smsFallbackUrl'], 'SmsMethod' => $options['smsMethod'], 'SmsUrl' => $options['smsUrl'], 'StatusCallback' => $options['statusCallback'], 'StatusCallbackMethod' => $options['statusCallbackMethod'], 'VoiceApplicationSid' => $options['voiceApplicationSid'], 'VoiceCallerIdLookup' => Serialize::booleanToString($options['voiceCallerIdLookup']), 'VoiceFallbackMethod' => $options['voiceFallbackMethod'], 'VoiceFallbackUrl' => $options['voiceFallbackUrl'], 'VoiceMethod' => $options['voiceMethod'], 'VoiceUrl' => $options['voiceUrl'], 'EmergencyStatus' => $options['emergencyStatus'], 'EmergencyAddressSid' => $options['emergencyAddressSid'], 'TrunkSid' => $options['trunkSid'], 'IdentitySid' => $options['identitySid'], 'AddressSid' => $options['addressSid'], 'VoiceReceiveMode' => $options['voiceReceiveMode'], 'BundleSid' => $options['bundleSid'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new IncomingPhoneNumberInstance($this->version, $payload, $this->solution['accountSid']);
    }

    protected function getLocal(): LocalList
    {
        if (!$this->_local) {
            $this->_local = new LocalList($this->version, $this->solution['accountSid']);
        }
        return $this->_local;
    }

    protected function getMobile(): MobileList
    {
        if (!$this->_mobile) {
            $this->_mobile = new MobileList($this->version, $this->solution['accountSid']);
        }
        return $this->_mobile;
    }

    protected function getTollFree(): TollFreeList
    {
        if (!$this->_tollFree) {
            $this->_tollFree = new TollFreeList($this->version, $this->solution['accountSid']);
        }
        return $this->_tollFree;
    }

    public function getContext(string $sid): IncomingPhoneNumberContext
    {
        return new IncomingPhoneNumberContext($this->version, $this->solution['accountSid'], $sid);
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
        return '[Twilio.Api.V2010.IncomingPhoneNumberList]';
    }
}