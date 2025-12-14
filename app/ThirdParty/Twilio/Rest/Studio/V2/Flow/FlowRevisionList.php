<?php

namespace Twilio\Rest\Studio\V2\Flow;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class FlowRevisionList extends ListResource
{
    public function __construct(Version $version, string $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Flows/' . rawurlencode($sid) . '/Revisions';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): FlowRevisionPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new FlowRevisionPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): FlowRevisionPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new FlowRevisionPage($this->version, $response, $this->solution);
    }

    public function getContext(string $revision): FlowRevisionContext
    {
        return new FlowRevisionContext($this->version, $this->solution['sid'], $revision);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V2.FlowRevisionList]';
    }
}