<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class TaskQueueStatisticsInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $workspaceSid, string $taskQueueSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'cumulative' => Values::array_get($payload, 'cumulative'), 'realtime' => Values::array_get($payload, 'realtime'), 'taskQueueSid' => Values::array_get($payload, 'task_queue_sid'), 'workspaceSid' => Values::array_get($payload, 'workspace_sid'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['workspaceSid' => $workspaceSid, 'taskQueueSid' => $taskQueueSid,];
    }

    protected function proxy(): TaskQueueStatisticsContext
    {
        if (!$this->context) {
            $this->context = new TaskQueueStatisticsContext($this->version, $this->solution['workspaceSid'], $this->solution['taskQueueSid']);
        }
        return $this->context;
    }

    public function fetch(array $options = []): TaskQueueStatisticsInstance
    {
        return $this->proxy()->fetch($options);
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown property: ' . $name);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Taskrouter.V1.TaskQueueStatisticsInstance ' . implode(' ', $context) . ']';
    }
}