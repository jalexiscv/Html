<?php

namespace Twilio\Rest\Autopilot\V1\Assistant;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class TaskList extends ListResource
{
    public function __construct(Version $version, string $assistantSid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/Tasks';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): TaskPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new TaskPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): TaskPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new TaskPage($this->version, $response, $this->solution);
    }

    public function create(string $uniqueName, array $options = []): TaskInstance
    {
        $options = new Values($options);
        $data = Values::of(['UniqueName' => $uniqueName, 'FriendlyName' => $options['friendlyName'], 'Actions' => Serialize::jsonObject($options['actions']), 'ActionsUrl' => $options['actionsUrl'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new TaskInstance($this->version, $payload, $this->solution['assistantSid']);
    }

    public function getContext(string $sid): TaskContext
    {
        return new TaskContext($this->version, $this->solution['assistantSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Autopilot.V1.TaskList]';
    }
}