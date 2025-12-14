<?php

namespace Twilio\Rest\Supersim\V1;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class UsageRecordList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/UsageRecords';
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
        $params = Values::of(['Sim' => $options['sim'], 'Fleet' => $options['fleet'], 'Network' => $options['network'], 'IsoCountry' => $options['isoCountry'], 'Group' => $options['group'], 'Granularity' => $options['granularity'], 'StartTime' => Serialize::iso8601DateTime($options['startTime']), 'EndTime' => Serialize::iso8601DateTime($options['endTime']), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
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
        return '[Twilio.Supersim.V1.UsageRecordList]';
    }
}