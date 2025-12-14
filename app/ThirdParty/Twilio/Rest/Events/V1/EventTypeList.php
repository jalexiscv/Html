<?php

namespace Twilio\Rest\Events\V1;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class EventTypeList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Types';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): EventTypePage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new EventTypePage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): EventTypePage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new EventTypePage($this->version, $response, $this->solution);
    }

    public function getContext(string $type): EventTypeContext
    {
        return new EventTypeContext($this->version, $type);
    }

    public function __toString(): string
    {
        return '[Twilio.Events.V1.EventTypeList]';
    }
}