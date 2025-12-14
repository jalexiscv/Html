<?php

namespace Twilio\Rest\Preview\Wireless;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class RatePlanList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/RatePlans';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): RatePlanPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new RatePlanPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): RatePlanPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new RatePlanPage($this->version, $response, $this->solution);
    }

    public function create(array $options = []): RatePlanInstance
    {
        $options = new Values($options);
        $data = Values::of(['UniqueName' => $options['uniqueName'], 'FriendlyName' => $options['friendlyName'], 'DataEnabled' => Serialize::booleanToString($options['dataEnabled']), 'DataLimit' => $options['dataLimit'], 'DataMetering' => $options['dataMetering'], 'MessagingEnabled' => Serialize::booleanToString($options['messagingEnabled']), 'VoiceEnabled' => Serialize::booleanToString($options['voiceEnabled']), 'CommandsEnabled' => Serialize::booleanToString($options['commandsEnabled']), 'NationalRoamingEnabled' => Serialize::booleanToString($options['nationalRoamingEnabled']), 'InternationalRoaming' => Serialize::map($options['internationalRoaming'], function ($e) {
            return $e;
        }),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new RatePlanInstance($this->version, $payload);
    }

    public function getContext(string $sid): RatePlanContext
    {
        return new RatePlanContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Wireless.RatePlanList]';
    }
}