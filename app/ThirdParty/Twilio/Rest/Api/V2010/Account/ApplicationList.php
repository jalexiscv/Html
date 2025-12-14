<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class ApplicationList extends ListResource
{
    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Applications.json';
    }

    public function create(array $options = []): ApplicationInstance
    {
        $options = new Values($options);
        $data = Values::of(['ApiVersion' => $options['apiVersion'], 'VoiceUrl' => $options['voiceUrl'], 'VoiceMethod' => $options['voiceMethod'], 'VoiceFallbackUrl' => $options['voiceFallbackUrl'], 'VoiceFallbackMethod' => $options['voiceFallbackMethod'], 'StatusCallback' => $options['statusCallback'], 'StatusCallbackMethod' => $options['statusCallbackMethod'], 'VoiceCallerIdLookup' => Serialize::booleanToString($options['voiceCallerIdLookup']), 'SmsUrl' => $options['smsUrl'], 'SmsMethod' => $options['smsMethod'], 'SmsFallbackUrl' => $options['smsFallbackUrl'], 'SmsFallbackMethod' => $options['smsFallbackMethod'], 'SmsStatusCallback' => $options['smsStatusCallback'], 'MessageStatusCallback' => $options['messageStatusCallback'], 'FriendlyName' => $options['friendlyName'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new ApplicationInstance($this->version, $payload, $this->solution['accountSid']);
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ApplicationPage
    {
        $options = new Values($options);
        $params = Values::of(['FriendlyName' => $options['friendlyName'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ApplicationPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ApplicationPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ApplicationPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): ApplicationContext
    {
        return new ApplicationContext($this->version, $this->solution['accountSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.ApplicationList]';
    }
}