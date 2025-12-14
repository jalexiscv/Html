<?php

namespace Twilio\Rest\Monitor\V1;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class AlertList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Alerts';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): AlertPage
    {
        $options = new Values($options);
        $params = Values::of(['LogLevel' => $options['logLevel'], 'StartDate' => Serialize::iso8601DateTime($options['startDate']), 'EndDate' => Serialize::iso8601DateTime($options['endDate']), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new AlertPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): AlertPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new AlertPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): AlertContext
    {
        return new AlertContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Monitor.V1.AlertList]';
    }
}