<?php

namespace Twilio\Rest\Voice\V1\DialingPermissions\Country;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class HighriskSpecialPrefixList extends ListResource
{
    public function __construct(Version $version, string $isoCode)
    {
        parent::__construct($version);
        $this->solution = ['isoCode' => $isoCode,];
        $this->uri = '/DialingPermissions/Countries/' . rawurlencode($isoCode) . '/HighRiskSpecialPrefixes';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): HighriskSpecialPrefixPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new HighriskSpecialPrefixPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): HighriskSpecialPrefixPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new HighriskSpecialPrefixPage($this->version, $response, $this->solution);
    }

    public function __toString(): string
    {
        return '[Twilio.Voice.V1.HighriskSpecialPrefixList]';
    }
}