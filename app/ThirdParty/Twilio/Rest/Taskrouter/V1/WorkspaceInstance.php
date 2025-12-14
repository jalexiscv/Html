<?php

namespace Twilio\Rest\Taskrouter\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Taskrouter\V1\Workspace\ActivityList;
use Twilio\Rest\Taskrouter\V1\Workspace\EventList;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskChannelList;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskList;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskQueueList;
use Twilio\Rest\Taskrouter\V1\Workspace\WorkerList;
use Twilio\Rest\Taskrouter\V1\Workspace\WorkflowList;
use Twilio\Rest\Taskrouter\V1\Workspace\WorkspaceCumulativeStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\WorkspaceRealTimeStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\WorkspaceStatisticsList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class WorkspaceInstance extends InstanceResource
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

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'defaultActivityName' => Values::array_get($payload, 'default_activity_name'), 'defaultActivitySid' => Values::array_get($payload, 'default_activity_sid'), 'eventCallbackUrl' => Values::array_get($payload, 'event_callback_url'), 'eventsFilter' => Values::array_get($payload, 'events_filter'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'multiTaskEnabled' => Values::array_get($payload, 'multi_task_enabled'), 'sid' => Values::array_get($payload, 'sid'), 'timeoutActivityName' => Values::array_get($payload, 'timeout_activity_name'), 'timeoutActivitySid' => Values::array_get($payload, 'timeout_activity_sid'), 'prioritizeQueueOrder' => Values::array_get($payload, 'prioritize_queue_order'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): WorkspaceContext
    {
        if (!$this->context) {
            $this->context = new WorkspaceContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): WorkspaceInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): WorkspaceInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getActivities(): ActivityList
    {
        return $this->proxy()->activities;
    }

    protected function getEvents(): EventList
    {
        return $this->proxy()->events;
    }

    protected function getTasks(): TaskList
    {
        return $this->proxy()->tasks;
    }

    protected function getTaskQueues(): TaskQueueList
    {
        return $this->proxy()->taskQueues;
    }

    protected function getWorkers(): WorkerList
    {
        return $this->proxy()->workers;
    }

    protected function getWorkflows(): WorkflowList
    {
        return $this->proxy()->workflows;
    }

    protected function getStatistics(): WorkspaceStatisticsList
    {
        return $this->proxy()->statistics;
    }

    protected function getRealTimeStatistics(): WorkspaceRealTimeStatisticsList
    {
        return $this->proxy()->realTimeStatistics;
    }

    protected function getCumulativeStatistics(): WorkspaceCumulativeStatisticsList
    {
        return $this->proxy()->cumulativeStatistics;
    }

    protected function getTaskChannels(): TaskChannelList
    {
        return $this->proxy()->taskChannels;
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
        return '[Twilio.Taskrouter.V1.WorkspaceInstance ' . implode(' ', $context) . ']';
    }
}