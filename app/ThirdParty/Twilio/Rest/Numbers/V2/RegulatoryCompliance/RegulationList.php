<?php

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class RegulationList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/RegulatoryCompliance/Regulations';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): RegulationPage
    {
        $options = new Values($options);
        $params = Values::of(['EndUserType' => $options['endUserType'], 'IsoCountry' => $options['isoCountry'], 'NumberType' => $options['numberType'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new RegulationPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): RegulationPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new RegulationPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): RegulationContext
    {
        return new RegulationContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Numbers.V2.RegulationList]';
    }
}