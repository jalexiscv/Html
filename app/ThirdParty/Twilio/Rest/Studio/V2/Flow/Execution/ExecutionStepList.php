<?php

namespace Twilio\Rest\Studio\V2\Flow\Execution;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class ExecutionStepList extends ListResource
{
    public function __construct(Version $version, string $flowSid, string $executionSid)
    {
        parent::__construct($version);
        $this->solution = ['flowSid' => $flowSid, 'executionSid' => $executionSid,];
        $this->uri = '/Flows/' . rawurlencode($flowSid) . '/Executions/' . rawurlencode($executionSid) . '/Steps';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ExecutionStepPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ExecutionStepPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ExecutionStepPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ExecutionStepPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): ExecutionStepContext
    {
        return new ExecutionStepContext($this->version, $this->solution['flowSid'], $this->solution['executionSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V2.ExecutionStepList]';
    }
}