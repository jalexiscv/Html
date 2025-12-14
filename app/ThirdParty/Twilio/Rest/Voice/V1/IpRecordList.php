<?php

namespace Twilio\Rest\Voice\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class IpRecordList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/IpRecords';
    }

    public function create(string $ipAddress, array $options = []): IpRecordInstance
    {
        $options = new Values($options);
        $data = Values::of(['IpAddress' => $ipAddress, 'FriendlyName' => $options['friendlyName'], 'CidrPrefixLength' => $options['cidrPrefixLength'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new IpRecordInstance($this->version, $payload);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): IpRecordPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new IpRecordPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): IpRecordPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new IpRecordPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): IpRecordContext
    {
        return new IpRecordContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Voice.V1.IpRecordList]';
    }
}