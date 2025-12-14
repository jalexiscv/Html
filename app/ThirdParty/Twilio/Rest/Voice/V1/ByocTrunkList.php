<?php

namespace Twilio\Rest\Voice\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class ByocTrunkList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/ByocTrunks';
    }

    public function create(array $options = []): ByocTrunkInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'VoiceUrl' => $options['voiceUrl'], 'VoiceMethod' => $options['voiceMethod'], 'VoiceFallbackUrl' => $options['voiceFallbackUrl'], 'VoiceFallbackMethod' => $options['voiceFallbackMethod'], 'StatusCallbackUrl' => $options['statusCallbackUrl'], 'StatusCallbackMethod' => $options['statusCallbackMethod'], 'CnamLookupEnabled' => Serialize::booleanToString($options['cnamLookupEnabled']), 'ConnectionPolicySid' => $options['connectionPolicySid'], 'FromDomainSid' => $options['fromDomainSid'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new ByocTrunkInstance($this->version, $payload);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ByocTrunkPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ByocTrunkPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ByocTrunkPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ByocTrunkPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): ByocTrunkContext
    {
        return new ByocTrunkContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Voice.V1.ByocTrunkList]';
    }
}