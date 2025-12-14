<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class WorkerChannelInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $workspaceSid, string $workerSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'assignedTasks' => Values::array_get($payload, 'assigned_tasks'), 'available' => Values::array_get($payload, 'available'), 'availableCapacityPercentage' => Values::array_get($payload, 'available_capacity_percentage'), 'configuredCapacity' => Values::array_get($payload, 'configured_capacity'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'sid' => Values::array_get($payload, 'sid'), 'taskChannelSid' => Values::array_get($payload, 'task_channel_sid'), 'taskChannelUniqueName' => Values::array_get($payload, 'task_channel_unique_name'), 'workerSid' => Values::array_get($payload, 'worker_sid'), 'workspaceSid' => Values::array_get($payload, 'workspace_sid'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['workspaceSid' => $workspaceSid, 'workerSid' => $workerSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): WorkerChannelContext
    {
        if (!$this->context) {
            $this->context = new WorkerChannelContext($this->version, $this->solution['workspaceSid'], $this->solution['workerSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): WorkerChannelInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): WorkerChannelInstance
    {
        return $this->proxy()->update($options);
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
        return '[Twilio.Taskrouter.V1.WorkerChannelInstance ' . implode(' ', $context) . ']';
    }
}