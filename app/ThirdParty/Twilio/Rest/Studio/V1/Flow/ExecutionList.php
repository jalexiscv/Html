<?php

namespace Twilio\Rest\Studio\V1\Flow;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class ExecutionList extends ListResource
{
    public function __construct(Version $version, string $flowSid)
    {
        parent::__construct($version);
        $this->solution = ['flowSid' => $flowSid,];
        $this->uri = '/Flows/' . rawurlencode($flowSid) . '/Executions';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ExecutionPage
    {
        $options = new Values($options);
        $params = Values::of(['DateCreatedFrom' => Serialize::iso8601DateTime($options['dateCreatedFrom']), 'DateCreatedTo' => Serialize::iso8601DateTime($options['dateCreatedTo']), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ExecutionPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ExecutionPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ExecutionPage($this->version, $response, $this->solution);
    }

    public function create(string $to, string $from, array $options = []): ExecutionInstance
    {
        $options = new Values($options);
        $data = Values::of(['To' => $to, 'From' => $from, 'Parameters' => Serialize::jsonObject($options['parameters']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new ExecutionInstance($this->version, $payload, $this->solution['flowSid']);
    }

    public function getContext(string $sid): ExecutionContext
    {
        return new ExecutionContext($this->version, $this->solution['flowSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V1.ExecutionList]';
    }
}