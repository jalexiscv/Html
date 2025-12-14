<?php

namespace Twilio\Rest\Studio\V1\Flow\Engagement;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class StepList extends ListResource
{
    public function __construct(Version $version, string $flowSid, string $engagementSid)
    {
        parent::__construct($version);
        $this->solution = ['flowSid' => $flowSid, 'engagementSid' => $engagementSid,];
        $this->uri = '/Flows/' . rawurlencode($flowSid) . '/Engagements/' . rawurlencode($engagementSid) . '/Steps';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): StepPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new StepPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): StepPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new StepPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): StepContext
    {
        return new StepContext($this->version, $this->solution['flowSid'], $this->solution['engagementSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V1.StepList]';
    }
}