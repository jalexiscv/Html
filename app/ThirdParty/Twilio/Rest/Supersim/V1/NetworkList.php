<?php

namespace Twilio\Rest\Supersim\V1;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class NetworkList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Networks';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): NetworkPage
    {
        $options = new Values($options);
        $params = Values::of(['IsoCountry' => $options['isoCountry'], 'Mcc' => $options['mcc'], 'Mnc' => $options['mnc'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new NetworkPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): NetworkPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new NetworkPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): NetworkContext
    {
        return new NetworkContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Supersim.V1.NetworkList]';
    }
}