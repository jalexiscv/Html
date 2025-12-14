<?php

namespace Twilio\Rest\Taskrouter\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Taskrouter\V1\Workspace\ActivityContext;
use Twilio\Rest\Taskrouter\V1\Workspace\ActivityList;
use Twilio\Rest\Taskrouter\V1\Workspace\EventContext;
use Twilio\Rest\Taskrouter\V1\Workspace\EventList;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskChannelContext;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskChannelList;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskContext;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskList;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskQueueContext;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskQueueList;
use Twilio\Rest\Taskrouter\V1\Workspace\WorkerContext;
use Twilio\Rest\Taskrouter\V1\Workspace\WorkerList;
use Twilio\Rest\Taskrouter\V1\Workspace\WorkflowContext;
use Twilio\Rest\Taskrouter\V1\Workspace\WorkflowList;
use Twilio\Rest\Taskrouter\V1\Workspace\WorkspaceCumulativeStatisticsContext;
use Twilio\Rest\Taskrouter\V1\Workspace\WorkspaceCumulativeStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\WorkspaceRealTimeStatisticsContext;
use Twilio\Rest\Taskrouter\V1\Workspace\WorkspaceRealTimeStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\WorkspaceStatisticsContext;
use Twilio\Rest\Taskrouter\V1\Workspace\WorkspaceStatisticsList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class WorkspaceContext extends InstanceContext
{
    protected $_activities;
    protected $_events;
    protected $_tasks;
    protected $_taskQueues;
    protected $_workers;
    protected $_workflows;
    protected $_statistics;
    protected $_realTimeStatistics;
    protected $_cumulativeStatistics;
    protected $_taskChannels;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Workspaces/' . rawurlencode($sid) . '';
    }

    public function fetch(): WorkspaceInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new WorkspaceInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): WorkspaceInstance
    {
        $options = new Values($options);
        $data = Values::of(['DefaultActivitySid' => $options['defaultActivitySid'], 'EventCallbackUrl' => $options['eventCallbackUrl'], 'EventsFilter' => $options['eventsFilter'], 'FriendlyName' => $options['friendlyName'], 'MultiTaskEnabled' => Serialize::booleanToString($options['multiTaskEnabled']), 'TimeoutActivitySid' => $options['timeoutActivitySid'], 'PrioritizeQueueOrder' => $options['prioritizeQueueOrder'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new WorkspaceInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getActivities(): ActivityList
    {
        if (!$this->_activities) {
            $this->_activities = new ActivityList($this->version, $this->solution['sid']);
        }
        return $this->_activities;
    }

    protected function getEvents(): EventList
    {
        if (!$this->_events) {
            $this->_events = new EventList($this->version, $this->solution['sid']);
        }
        return $this->_events;
    }

    protected function getTasks(): TaskList
    {
        if (!$this->_tasks) {
            $this->_tasks = new TaskList($this->version, $this->solution['sid']);
        }
        return $this->_tasks;
    }

    protected function getTaskQueues(): TaskQueueList
    {
        if (!$this->_taskQueues) {
            $this->_taskQueues = new TaskQueueList($this->version, $this->solution['sid']);
        }
        return $this->_taskQueues;
    }

    protected function getWorkers(): WorkerList
    {
        if (!$this->_workers) {
            $this->_workers = new WorkerList($this->version, $this->solution['sid']);
        }
        return $this->_workers;
    }

    protected function getWorkflows(): WorkflowList
    {
        if (!$this->_workflows) {
            $this->_workflows = new WorkflowList($this->version, $this->solution['sid']);
        }
        return $this->_workflows;
    }

    protected function getStatistics(): WorkspaceStatisticsList
    {
        if (!$this->_statistics) {
            $this->_statistics = new WorkspaceStatisticsList($this->version, $this->solution['sid']);
        }
        return $this->_statistics;
    }

    protected function getRealTimeStatistics(): WorkspaceRealTimeStatisticsList
    {
        if (!$this->_realTimeStatistics) {
            $this->_realTimeStatistics = new WorkspaceRealTimeStatisticsList($this->version, $this->solution['sid']);
        }
        return $this->_realTimeStatistics;
    }

    protected function getCumulativeStatistics(): WorkspaceCumulativeStatisticsList
    {
        if (!$this->_cumulativeStatistics) {
            $this->_cumulativeStatistics = new WorkspaceCumulativeStatisticsList($this->version, $this->solution['sid']);
        }
        return $this->_cumulativeStatistics;
    }

    protected function getTaskChannels(): TaskChannelList
    {
        if (!$this->_taskChannels) {
            $this->_taskChannels = new TaskChannelList($this->version, $this->solution['sid']);
        }
        return $this->_taskChannels;
    }

    public function __get(string $name): ListResource
    {
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown subresource ' . $name);
    }

    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }
        throw new TwilioException('Resource does not have a context');
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Taskrouter.V1.WorkspaceContext ' . implode(' ', $context) . ']';
    }
}