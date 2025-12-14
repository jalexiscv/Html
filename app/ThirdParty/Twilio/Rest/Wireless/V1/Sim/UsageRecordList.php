<?php

namespace Twilio\Rest\Wireless\V1\Sim;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class UsageRecordList extends ListResource
{
    public function __construct(Version $version, string $simSid)
    {
        parent::__construct($version);
        $this->solution = ['simSid' => $simSid,];
        $this->uri = '/Sims/' . rawurlencode($simSid) . '/UsageRecords';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): UsageRecordPage
    {
        $options = new Values($options);
        $params = Values::of(['End' => Serialize::iso8601DateTime($options['end']), 'Start' => Serialize::iso8601DateTime($options['start']), 'Granularity' => $options['granularity'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new UsageRecordPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): UsageRecordPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new UsageRecordPage($this->version, $response, $this->solution);
    }

    public function __toString(): string
    {
        return '[Twilio.Wireless.V1.UsageRecordList]';
    }
}