<?php

namespace Twilio\Rest\Wireless\V1\Sim;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class DataSessionList extends ListResource
{
    public function __construct(Version $version, string $simSid)
    {
        parent::__construct($version);
        $this->solution = ['simSid' => $simSid,];
        $this->uri = '/Sims/' . rawurlencode($simSid) . '/DataSessions';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): DataSessionPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new DataSessionPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): DataSessionPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new DataSessionPage($this->version, $response, $this->solution);
    }

    public function __toString(): string
    {
        return '[Twilio.Wireless.V1.DataSessionList]';
    }
}