<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

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

class WorkspaceCumulativeStatisticsInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $workspaceSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'avgTaskAcceptanceTime' => Values::array_get($payload, 'avg_task_acceptance_time'), 'startTime' => Deserialize::dateTime(Values::array_get($payload, 'start_time')), 'endTime' => Deserialize::dateTime(Values::array_get($payload, 'end_time')), 'reservationsCreated' => Values::array_get($payload, 'reservations_created'), 'reservationsAccepted' => Values::array_get($payload, 'reservations_accepted'), 'reservationsRejected' => Values::array_get($payload, 'reservations_rejected'), 'reservationsTimedOut' => Values::array_get($payload, 'reservations_timed_out'), 'reservationsCanceled' => Values::array_get($payload, 'reservations_canceled'), 'reservationsRescinded' => Values::array_get($payload, 'reservations_rescinded'), 'splitByWaitTime' => Values::array_get($payload, 'split_by_wait_time'), 'waitDurationUntilAccepted' => Values::array_get($payload, 'wait_duration_until_accepted'), 'waitDurationUntilCanceled' => Values::array_get($payload, 'wait_duration_until_canceled'), 'tasksCanceled' => Values::array_get($payload, 'tasks_canceled'), 'tasksCompleted' => Values::array_get($payload, 'tasks_completed'), 'tasksCreated' => Values::array_get($payload, 'tasks_created'), 'tasksDeleted' => Values::array_get($payload, 'tasks_deleted'), 'tasksMoved' => Values::array_get($payload, 'tasks_moved'), 'tasksTimedOutInWorkflow' => Values::array_get($payload, 'tasks_timed_out_in_workflow'), 'workspaceSid' => Values::array_get($payload, 'workspace_sid'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['workspaceSid' => $workspaceSid,];
    }

    protected function proxy(): WorkspaceCumulativeStatisticsContext
    {
        if (!$this->context) {
            $this->context = new WorkspaceCumulativeStatisticsContext($this->version, $this->solution['workspaceSid']);
        }
        return $this->context;
    }

    public function fetch(array $options = []): WorkspaceCumulativeStatisticsInstance
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
        return '[Twilio.Taskrouter.V1.WorkspaceCumulativeStatisticsInstance ' . implode(' ', $context) . ']';
    }
}