<?php

namespace Twilio\Rest\Voice\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class SourceIpMappingList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/SourceIpMappings';
    }

    public function create(string $ipRecordSid, string $sipDomainSid): SourceIpMappingInstance
    {
        $data = Values::of(['IpRecordSid' => $ipRecordSid, 'SipDomainSid' => $sipDomainSid,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new SourceIpMappingInstance($this->version, $payload);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): SourceIpMappingPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new SourceIpMappingPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): SourceIpMappingPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new SourceIpMappingPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): SourceIpMappingContext
    {
        return new SourceIpMappingContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Voice.V1.SourceIpMappingList]';
    }
}