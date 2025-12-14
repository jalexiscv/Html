<?php

namespace Twilio\Rest\Insights\V1\Call;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class MetricList extends ListResource
{
    public function __construct(Version $version, string $callSid)
    {
        parent::__construct($version);
        $this->solution = ['callSid' => $callSid,];
        $this->uri = '/Voice/' . rawurlencode($callSid) . '/Metrics';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): MetricPage
    {
        $options = new Values($options);
        $params = Values::of(['Edge' => $options['edge'], 'Direction' => $options['direction'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new MetricPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): MetricPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new MetricPage($this->version, $response, $this->solution);
    }

    public function __toString(): string
    {
        return '[Twilio.Insights.V1.MetricList]';
    }
}