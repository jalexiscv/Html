<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class WorkspaceRealTimeStatisticsInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $workspaceSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'activityStatistics' => Values::array_get($payload, 'activity_statistics'), 'longestTaskWaitingAge' => Values::array_get($payload, 'longest_task_waiting_age'), 'longestTaskWaitingSid' => Values::array_get($payload, 'longest_task_waiting_sid'), 'tasksByPriority' => Values::array_get($payload, 'tasks_by_priority'), 'tasksByStatus' => Values::array_get($payload, 'tasks_by_status'), 'totalTasks' => Values::array_get($payload, 'total_tasks'), 'totalWorkers' => Values::array_get($payload, 'total_workers'), 'workspaceSid' => Values::array_get($payload, 'workspace_sid'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['workspaceSid' => $workspaceSid,];
    }

    protected function proxy(): WorkspaceRealTimeStatisticsContext
    {
        if (!$this->context) {
            $this->context = new WorkspaceRealTimeStatisticsContext($this->version, $this->solution['workspaceSid']);
        }
        return $this->context;
    }

    public function fetch(array $options = []): WorkspaceRealTimeStatisticsInstance
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
        return '[Twilio.Taskrouter.V1.WorkspaceRealTimeStatisticsInstance ' . implode(' ', $context) . ']';
    }
}