<?php

namespace Twilio\Rest\Voice\V1\DialingPermissions;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
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
        $this->uri = '/DialingPermissions/Countries';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): CountryPage
    {
        $options = new Values($options);
        $params = Values::of(['IsoCode' => $options['isoCode'], 'Continent' => $options['continent'], 'CountryCode' => $options['countryCode'], 'LowRiskNumbersEnabled' => Serialize::booleanToString($options['lowRiskNumbersEnabled']), 'HighRiskSpecialNumbersEnabled' => Serialize::booleanToString($options['highRiskSpecialNumbersEnabled']), 'HighRiskTollfraudNumbersEnabled' => Serialize::booleanToString($options['highRiskTollfraudNumbersEnabled']), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new CountryPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): CountryPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new CountryPage($this->version, $response, $this->solution);
    }

    public function getContext(string $isoCode): CountryContext
    {
        return new CountryContext($this->version, $isoCode);
    }

    public function __toString(): string
    {
        return '[Twilio.Voice.V1.CountryList]';
    }
}