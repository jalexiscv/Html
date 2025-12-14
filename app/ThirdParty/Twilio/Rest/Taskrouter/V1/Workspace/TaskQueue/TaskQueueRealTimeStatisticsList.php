<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue;

use Twilio\ListResource;
use Twilio\Version;

class TaskQueueRealTimeStatisticsList extends ListResource
{
    public function __construct(Version $version, string $workspaceSid, string $taskQueueSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid, 'taskQueueSid' => $taskQueueSid,];
    }

    public function getContext(): TaskQueueRealTimeStatisticsContext
    {
        return new TaskQueueRealTimeStatisticsContext($this->version, $this->solution['workspaceSid'], $this->solution['taskQueueSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.TaskQueueRealTimeStatisticsList]';
    }
}