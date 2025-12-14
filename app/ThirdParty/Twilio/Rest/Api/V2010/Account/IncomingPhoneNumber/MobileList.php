<?php

namespace Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class MobileList extends ListResource
{
    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/IncomingPhoneNumbers/Mobile.json';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): MobilePage
    {
        $options = new Values($options);
        $params = Values::of(['Beta' => Serialize::booleanToString($options['beta']), 'FriendlyName' => $options['friendlyName'], 'PhoneNumber' => $options['phoneNumber'], 'Origin' => $options['origin'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new MobilePage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): MobilePage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new MobilePage($this->version, $response, $this->solution);
    }

    public function create(string $phoneNumber, array $options = []): MobileInstance
    {
        $options = new Values($options);
        $data = Values::of(['PhoneNumber' => $phoneNumber, 'ApiVersion' => $options['apiVersion'], 'FriendlyName' => $options['friendlyName'], 'SmsApplicationSid' => $options['smsApplicationSid'], 'SmsFallbackMethod' => $options['smsFallbackMethod'], 'SmsFallbackUrl' => $options['smsFallbackUrl'], 'SmsMethod' => $options['smsMethod'], 'SmsUrl' => $options['smsUrl'], 'StatusCallback' => $options['statusCallback'], 'StatusCallbackMethod' => $options['statusCallbackMethod'], 'VoiceApplicationSid' => $options['voiceApplicationSid'], 'VoiceCallerIdLookup' => Serialize::booleanToString($options['voiceCallerIdLookup']), 'VoiceFallbackMethod' => $options['voiceFallbackMethod'], 'VoiceFallbackUrl' => $options['voiceFallbackUrl'], 'VoiceMethod' => $options['voiceMethod'], 'VoiceUrl' => $options['voiceUrl'], 'IdentitySid' => $options['identitySid'], 'AddressSid' => $options['addressSid'], 'EmergencyStatus' => $options['emergencyStatus'], 'EmergencyAddressSid' => $options['emergencyAddressSid'], 'TrunkSid' => $options['trunkSid'], 'VoiceReceiveMode' => $options['voiceReceiveMode'], 'BundleSid' => $options['bundleSid'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new MobileInstance($this->version, $payload, $this->solution['accountSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.MobileList]';
    }
}