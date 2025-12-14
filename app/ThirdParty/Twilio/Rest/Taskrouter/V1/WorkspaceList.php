<?php

namespace Twilio\Rest\Taskrouter\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class WorkspaceList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Workspaces';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): WorkspacePage
    {
        $options = new Values($options);
        $params = Values::of(['FriendlyName' => $options['friendlyName'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new WorkspacePage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): WorkspacePage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new WorkspacePage($this->version, $response, $this->solution);
    }

    public function create(string $friendlyName, array $options = []): WorkspaceInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $friendlyName, 'EventCallbackUrl' => $options['eventCallbackUrl'], 'EventsFilter' => $options['eventsFilter'], 'MultiTaskEnabled' => Serialize::booleanToString($options['multiTaskEnabled']), 'Template' => $options['template'], 'PrioritizeQueueOrder' => $options['prioritizeQueueOrder'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new WorkspaceInstance($this->version, $payload);
    }

    public function getContext(string $sid): WorkspaceContext
    {
        return new WorkspaceContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.WorkspaceList]';
    }
}