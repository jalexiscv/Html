<?php

namespace Twilio\Rest\Autopilot\V1\Assistant\Task;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class TaskStatisticsContext extends InstanceContext
{
    public function __construct(Version $version, $assistantSid, $taskSid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid, 'taskSid' => $taskSid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/Tasks/' . rawurlencode($taskSid) . '/Statistics';
    }

    public function fetch(): TaskStatisticsInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new TaskStatisticsInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['taskSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Autopilot.V1.TaskStatisticsContext ' . implode(' ', $context) . ']';
    }
}