<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class TaskQueueCumulativeStatisticsPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): TaskQueueCumulativeStatisticsInstance
    {
        return new TaskQueueCumulativeStatisticsInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['taskQueueSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.TaskQueueCumulativeStatisticsPage]';
    }
}