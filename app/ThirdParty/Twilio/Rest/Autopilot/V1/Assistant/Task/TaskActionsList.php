<?php

namespace Twilio\Rest\Autopilot\V1\Assistant\Task;

use Twilio\ListResource;
use Twilio\Version;

class TaskActionsList extends ListResource
{
    public function __construct(Version $version, string $assistantSid, string $taskSid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid, 'taskSid' => $taskSid,];
    }

    public function getContext(): TaskActionsContext
    {
        return new TaskActionsContext($this->version, $this->solution['assistantSid'], $this->solution['taskSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Autopilot.V1.TaskActionsList]';
    }
}