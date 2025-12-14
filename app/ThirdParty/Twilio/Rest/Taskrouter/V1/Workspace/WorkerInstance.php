<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Taskrouter\V1\Workspace\Worker\ReservationList;
use Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkerChannelList;
use Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkerStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkersCumulativeStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkersRealTimeStatisticsList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class WorkerInstance extends InstanceResource
{
    protected $_realTimeStatistics;
    protected $_cumulativeStatistics;
    protected $_statistics;
    protected $_reservations;
    protected $_workerChannels;

    public function __construct(Version $version, array $payload, string $workspaceSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'activityName' => Values::array_get($payload, 'activity_name'), 'activitySid' => Values::array_get($payload, 'activity_sid'), 'attributes' => Values::array_get($payload, 'attributes'), 'available' => Values::array_get($payload, 'available'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateStatusChanged' => Deserialize::dateTime(Values::array_get($payload, 'date_status_changed')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'sid' => Values::array_get($payload, 'sid'), 'workspaceSid' => Values::array_get($payload, 'workspace_sid'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['workspaceSid' => $workspaceSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): WorkerContext
    {
        if (!$this->context) {
            $this->context = new WorkerContext($this->version, $this->solution['workspaceSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): WorkerInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): WorkerInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getRealTimeStatistics(): WorkersRealTimeStatisticsList
    {
        return $this->proxy()->realTimeStatistics;
    }

    protected function getCumulativeStatistics(): WorkersCumulativeStatisticsList
    {
        return $this->proxy()->cumulativeStatistics;
    }

    protected function getStatistics(): WorkerStatisticsList
    {
        return $this->proxy()->statistics;
    }

    protected function getReservations(): ReservationList
    {
        return $this->proxy()->reservations;
    }

    protected function getWorkerChannels(): WorkerChannelList
    {
        return $this->proxy()->workerChannels;
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
        return '[Twilio.Taskrouter.V1.WorkerInstance ' . implode(' ', $context) . ']';
    }
}