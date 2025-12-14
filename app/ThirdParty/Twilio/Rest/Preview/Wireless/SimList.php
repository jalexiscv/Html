<?php

namespace Twilio\Rest\Preview\Wireless;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class SimList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Sims';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): SimPage
    {
        $options = new Values($options);
        $params = Values::of(['Status' => $options['status'], 'Iccid' => $options['iccid'], 'RatePlan' => $options['ratePlan'], 'EId' => $options['eId'], 'SimRegistrationCode' => $options['simRegistrationCode'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new SimPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): SimPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new SimPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): SimContext
    {
        return new SimContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Wireless.SimList]';
    }
}