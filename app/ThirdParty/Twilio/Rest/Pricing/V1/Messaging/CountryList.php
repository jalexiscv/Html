<?php

namespace Twilio\Rest\Pricing\V1\Messaging;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class CountryList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Messaging/Countries';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): CountryPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new CountryPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): CountryPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new CountryPage($this->version, $response, $this->solution);
    }

    public function getContext(string $isoCountry): CountryContext
    {
        return new CountryContext($this->version, $isoCountry);
    }

    public function __toString(): string
    {
        return '[Twilio.Pricing.V1.CountryList]';
    }
}