<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

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
    public function __construct(Version $version, string $workspaceSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Tasks';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): TaskPage
    {
        $options = new Values($options);
        $params = Values::of(['Priority' => $options['priority'], 'AssignmentStatus' => Serialize::map($options['assignmentStatus'], function ($e) {
            return $e;
        }), 'WorkflowSid' => $options['workflowSid'], 'WorkflowName' => $options['workflowName'], 'TaskQueueSid' => $options['taskQueueSid'], 'TaskQueueName' => $options['taskQueueName'], 'EvaluateTaskAttributes' => $options['evaluateTaskAttributes'], 'Ordering' => $options['ordering'], 'HasAddons' => Serialize::booleanToString($options['hasAddons']), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new TaskPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): TaskPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new TaskPage($this->version, $response, $this->solution);
    }

    public function create(array $options = []): TaskInstance
    {
        $options = new Values($options);
        $data = Values::of(['Timeout' => $options['timeout'], 'Priority' => $options['priority'], 'TaskChannel' => $options['taskChannel'], 'WorkflowSid' => $options['workflowSid'], 'Attributes' => $options['attributes'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new TaskInstance($this->version, $payload, $this->solution['workspaceSid']);
    }

    public function getContext(string $sid): TaskContext
    {
        return new TaskContext($this->version, $this->solution['workspaceSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.TaskList]';
    }
}