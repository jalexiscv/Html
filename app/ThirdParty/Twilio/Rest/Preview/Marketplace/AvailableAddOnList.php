<?php

namespace Twilio\Rest\Preview\Marketplace;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class AvailableAddOnList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/AvailableAddOns';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): AvailableAddOnPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new AvailableAddOnPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): AvailableAddOnPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new AvailableAddOnPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): AvailableAddOnContext
    {
        return new AvailableAddOnContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Marketplace.AvailableAddOnList]';
    }
}