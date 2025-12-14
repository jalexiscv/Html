<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Taskrouter\V1\Workspace\Task\ReservationList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class TaskInstance extends InstanceResource
{
    protected $_reservations;

    public function __construct(Version $version, array $payload, string $workspaceSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'age' => Values::array_get($payload, 'age'), 'assignmentStatus' => Values::array_get($payload, 'assignment_status'), 'attributes' => Values::array_get($payload, 'attributes'), 'addons' => Values::array_get($payload, 'addons'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'taskQueueEnteredDate' => Deserialize::dateTime(Values::array_get($payload, 'task_queue_entered_date')), 'priority' => Values::array_get($payload, 'priority'), 'reason' => Values::array_get($payload, 'reason'), 'sid' => Values::array_get($payload, 'sid'), 'taskQueueSid' => Values::array_get($payload, 'task_queue_sid'), 'taskQueueFriendlyName' => Values::array_get($payload, 'task_queue_friendly_name'), 'taskChannelSid' => Values::array_get($payload, 'task_channel_sid'), 'taskChannelUniqueName' => Values::array_get($payload, 'task_channel_unique_name'), 'timeout' => Values::array_get($payload, 'timeout'), 'workflowSid' => Values::array_get($payload, 'workflow_sid'), 'workflowFriendlyName' => Values::array_get($payload, 'workflow_friendly_name'), 'workspaceSid' => Values::array_get($payload, 'workspace_sid'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['workspaceSid' => $workspaceSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): TaskContext
    {
        if (!$this->context) {
            $this->context = new TaskContext($this->version, $this->solution['workspaceSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): TaskInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): TaskInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getReservations(): ReservationList
    {
        return $this->proxy()->reservations;
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
        return '[Twilio.Taskrouter.V1.TaskInstance ' . implode(' ', $context) . ']';
    }
}