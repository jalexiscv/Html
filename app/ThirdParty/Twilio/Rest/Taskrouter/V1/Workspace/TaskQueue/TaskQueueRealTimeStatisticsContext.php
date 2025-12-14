<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class TaskQueueRealTimeStatisticsContext extends InstanceContext
{
    public function __construct(Version $version, $workspaceSid, $taskQueueSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid, 'taskQueueSid' => $taskQueueSid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/TaskQueues/' . rawurlencode($taskQueueSid) . '/RealTimeStatistics';
    }

    public function fetch(array $options = []): TaskQueueRealTimeStatisticsInstance
    {
        $options = new Values($options);
        $params = Values::of(['TaskChannel' => $options['taskChannel'],]);
        $payload = $this->version->fetch('GET', $this->uri, $params);
        return new TaskQueueRealTimeStatisticsInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['taskQueueSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Taskrouter.V1.TaskQueueRealTimeStatisticsContext ' . implode(' ', $context) . ']';
    }
}