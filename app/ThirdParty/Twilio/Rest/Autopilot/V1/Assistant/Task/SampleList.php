<?php

namespace Twilio\Rest\Autopilot\V1\Assistant\Task;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class SampleList extends ListResource
{
    public function __construct(Version $version, string $assistantSid, string $taskSid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid, 'taskSid' => $taskSid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/Tasks/' . rawurlencode($taskSid) . '/Samples';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): SamplePage
    {
        $options = new Values($options);
        $params = Values::of(['Language' => $options['language'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new SamplePage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): SamplePage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new SamplePage($this->version, $response, $this->solution);
    }

    public function create(string $language, string $taggedText, array $options = []): SampleInstance
    {
        $options = new Values($options);
        $data = Values::of(['Language' => $language, 'TaggedText' => $taggedText, 'SourceChannel' => $options['sourceChannel'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new SampleInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['taskSid']);
    }

    public function getContext(string $sid): SampleContext
    {
        return new SampleContext($this->version, $this->solution['assistantSid'], $this->solution['taskSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Autopilot.V1.SampleList]';
    }
}