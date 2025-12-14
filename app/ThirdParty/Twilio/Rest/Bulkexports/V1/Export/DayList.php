<?php

namespace Twilio\Rest\Bulkexports\V1\Export;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class DayList extends ListResource
{
    public function __construct(Version $version, string $resourceType)
    {
        parent::__construct($version);
        $this->solution = ['resourceType' => $resourceType,];
        $this->uri = '/Exports/' . rawurlencode($resourceType) . '/Days';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): DayPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new DayPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): DayPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new DayPage($this->version, $response, $this->solution);
    }

    public function getContext(string $day): DayContext
    {
        return new DayContext($this->version, $this->solution['resourceType'], $day);
    }

    public function __toString(): string
    {
        return '[Twilio.Bulkexports.V1.DayList]';
    }
}