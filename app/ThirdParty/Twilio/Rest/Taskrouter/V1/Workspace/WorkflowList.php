<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class WorkflowList extends ListResource
{
    public function __construct(Version $version, string $workspaceSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Workflows';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): WorkflowPage
    {
        $options = new Values($options);
        $params = Values::of(['FriendlyName' => $options['friendlyName'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new WorkflowPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): WorkflowPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new WorkflowPage($this->version, $response, $this->solution);
    }

    public function create(string $friendlyName, string $configuration, array $options = []): WorkflowInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $friendlyName, 'Configuration' => $configuration, 'AssignmentCallbackUrl' => $options['assignmentCallbackUrl'], 'FallbackAssignmentCallbackUrl' => $options['fallbackAssignmentCallbackUrl'], 'TaskReservationTimeout' => $options['taskReservationTimeout'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new WorkflowInstance($this->version, $payload, $this->solution['workspaceSid']);
    }

    public function getContext(string $sid): WorkflowContext
    {
        return new WorkflowContext($this->version, $this->solution['workspaceSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.WorkflowList]';
    }
}