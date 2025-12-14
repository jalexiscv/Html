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

class WorkersCumulativeStatisticsInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $workspaceSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'startTime' => Deserialize::dateTime(Values::array_get($payload, 'start_time')), 'endTime' => Deserialize::dateTime(Values::array_get($payload, 'end_time')), 'activityDurations' => Values::array_get($payload, 'activity_durations'), 'reservationsCreated' => Values::array_get($payload, 'reservations_created'), 'reservationsAccepted' => Values::array_get($payload, 'reservations_accepted'), 'reservationsRejected' => Values::array_get($payload, 'reservations_rejected'), 'reservationsTimedOut' => Values::array_get($payload, 'reservations_timed_out'), 'reservationsCanceled' => Values::array_get($payload, 'reservations_canceled'), 'reservationsRescinded' => Values::array_get($payload, 'reservations_rescinded'), 'workspaceSid' => Values::array_get($payload, 'workspace_sid'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['workspaceSid' => $workspaceSid,];
    }

    protected function proxy(): WorkersCumulativeStatisticsContext
    {
        if (!$this->context) {
            $this->context = new WorkersCumulativeStatisticsContext($this->version, $this->solution['workspaceSid']);
        }
        return $this->context;
    }

    public function fetch(array $options = []): WorkersCumulativeStatisticsInstance
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
        return '[Twilio.Taskrouter.V1.WorkersCumulativeStatisticsInstance ' . implode(' ', $context) . ']';
    }
}