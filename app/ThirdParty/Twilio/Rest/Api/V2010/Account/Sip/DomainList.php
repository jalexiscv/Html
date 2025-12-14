<?php

namespace Twilio\Rest\Api\V2010\Account\Sip;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class DomainList extends ListResource
{
    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/SIP/Domains.json';
    }

    public function stream(int $limit = null, $pageSize = null): Stream
    {
        $limits = $this->version->readLimits($limit, $pageSize);
        $page = $this->page($limits['pageSize']);
        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    public function read(int $limit = null, $pageSize = null): array
    {
        return iterator_to_array($this->stream($limit, $pageSize), false);
    }

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): DomainPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new DomainPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): DomainPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new DomainPage($this->version, $response, $this->solution);
    }

    public function create(string $domainName, array $options = []): DomainInstance
    {
        $options = new Values($options);
        $data = Values::of(['DomainName' => $domainName, 'FriendlyName' => $options['friendlyName'], 'VoiceUrl' => $options['voiceUrl'], 'VoiceMethod' => $options['voiceMethod'], 'VoiceFallbackUrl' => $options['voiceFallbackUrl'], 'VoiceFallbackMethod' => $options['voiceFallbackMethod'], 'VoiceStatusCallbackUrl' => $options['voiceStatusCallbackUrl'], 'VoiceStatusCallbackMethod' => $options['voiceStatusCallbackMethod'], 'SipRegistration' => Serialize::booleanToString($options['sipRegistration']), 'EmergencyCallingEnabled' => Serialize::booleanToString($options['emergencyCallingEnabled']), 'Secure' => Serialize::booleanToString($options['secure']), 'ByocTrunkSid' => $options['byocTrunkSid'], 'EmergencyCallerSid' => $options['emergencyCallerSid'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new DomainInstance($this->version, $payload, $this->solution['accountSid']);
    }

    public function getContext(string $sid): DomainContext
    {
        return new DomainContext($this->version, $this->solution['accountSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.DomainList]';
    }
}