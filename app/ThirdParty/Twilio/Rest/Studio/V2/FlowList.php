<?php

namespace Twilio\Rest\Studio\V2;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class FlowList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Flows';
    }

    public function create(string $friendlyName, string $status, array $definition, array $options = []): FlowInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $friendlyName, 'Status' => $status, 'Definition' => Serialize::jsonObject($definition), 'CommitMessage' => $options['commitMessage'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new FlowInstance($this->version, $payload);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): FlowPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new FlowPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): FlowPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new FlowPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): FlowContext
    {
        return new FlowContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V2.FlowList]';
    }
}