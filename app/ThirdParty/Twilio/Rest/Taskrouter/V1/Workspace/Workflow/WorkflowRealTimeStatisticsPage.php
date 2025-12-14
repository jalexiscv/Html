<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Workflow;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class WorkflowRealTimeStatisticsPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): WorkflowRealTimeStatisticsInstance
    {
        return new WorkflowRealTimeStatisticsInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['workflowSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.WorkflowRealTimeStatisticsPage]';
    }
}