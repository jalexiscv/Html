<?php

namespace Twilio\Rest\Autopilot\V1\Assistant;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class QueryList extends ListResource
{
    public function __construct(Version $version, string $assistantSid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/Queries';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): QueryPage
    {
        $options = new Values($options);
        $params = Values::of(['Language' => $options['language'], 'ModelBuild' => $options['modelBuild'], 'Status' => $options['status'], 'DialogueSid' => $options['dialogueSid'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new QueryPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): QueryPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new QueryPage($this->version, $response, $this->solution);
    }

    public function create(string $language, string $query, array $options = []): QueryInstance
    {
        $options = new Values($options);
        $data = Values::of(['Language' => $language, 'Query' => $query, 'Tasks' => $options['tasks'], 'ModelBuild' => $options['modelBuild'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new QueryInstance($this->version, $payload, $this->solution['assistantSid']);
    }

    public function getContext(string $sid): QueryContext
    {
        return new QueryContext($this->version, $this->solution['assistantSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Autopilot.V1.QueryList]';
    }
}