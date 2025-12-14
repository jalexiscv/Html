<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Workflow;

use Twilio\ListResource;
use Twilio\Version;

class WorkflowStatisticsList extends ListResource
{
    public function __construct(Version $version, string $workspaceSid, string $workflowSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid, 'workflowSid' => $workflowSid,];
    }

    public function getContext(): WorkflowStatisticsContext
    {
        return new WorkflowStatisticsContext($this->version, $this->solution['workspaceSid'], $this->solution['workflowSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.WorkflowStatisticsList]';
    }
}