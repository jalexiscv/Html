<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue\TaskQueueCumulativeStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue\TaskQueueRealTimeStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue\TaskQueueStatisticsList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class TaskQueueInstance extends InstanceResource
{
    protected $_statistics;
    protected $_realTimeStatistics;
    protected $_cumulativeStatistics;

    public function __construct(Version $version, array $payload, string $workspaceSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'assignmentActivitySid' => Values::array_get($payload, 'assignment_activity_sid'), 'assignmentActivityName' => Values::array_get($payload, 'assignment_activity_name'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'maxReservedWorkers' => Values::array_get($payload, 'max_reserved_workers'), 'reservationActivitySid' => Values::array_get($payload, 'reservation_activity_sid'), 'reservationActivityName' => Values::array_get($payload, 'reservation_activity_name'), 'sid' => Values::array_get($payload, 'sid'), 'targetWorkers' => Values::array_get($payload, 'target_workers'), 'taskOrder' => Values::array_get($payload, 'task_order'), 'url' => Values::array_get($payload, 'url'), 'workspaceSid' => Values::array_get($payload, 'workspace_sid'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['workspaceSid' => $workspaceSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): TaskQueueContext
    {
        if (!$this->context) {
            $this->context = new TaskQueueContext($this->version, $this->solution['workspaceSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): TaskQueueInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): TaskQueueInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getStatistics(): TaskQueueStatisticsList
    {
        return $this->proxy()->statistics;
    }

    protected function getRealTimeStatistics(): TaskQueueRealTimeStatisticsList
    {
        return $this->proxy()->realTimeStatistics;
    }

    protected function getCumulativeStatistics(): TaskQueueCumulativeStatisticsList
    {
        return $this->proxy()->cumulativeStatistics;
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
        return '[Twilio.Taskrouter.V1.TaskQueueInstance ' . implode(' ', $context) . ']';
    }
}