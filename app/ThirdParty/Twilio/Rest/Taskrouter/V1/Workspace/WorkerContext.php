<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Taskrouter\V1\Workspace\Worker\ReservationContext;
use Twilio\Rest\Taskrouter\V1\Workspace\Worker\ReservationList;
use Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkerChannelContext;
use Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkerChannelList;
use Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkersCumulativeStatisticsContext;
use Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkersRealTimeStatisticsContext;
use Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkerStatisticsContext;
use Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkerStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkersCumulativeStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkersRealTimeStatisticsList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class WorkerContext extends InstanceContext
{
    protected $_realTimeStatistics;
    protected $_cumulativeStatistics;
    protected $_statistics;
    protected $_reservations;
    protected $_workerChannels;

    public function __construct(Version $version, $workspaceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid, 'sid' => $sid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Workers/' . rawurlencode($sid) . '';
    }

    public function fetch(): WorkerInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new WorkerInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['sid']);
    }

    public function update(array $options = []): WorkerInstance
    {
        $options = new Values($options);
        $data = Values::of(['ActivitySid' => $options['activitySid'], 'Attributes' => $options['attributes'], 'FriendlyName' => $options['friendlyName'], 'RejectPendingReservations' => Serialize::booleanToString($options['rejectPendingReservations']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new WorkerInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getRealTimeStatistics(): WorkersRealTimeStatisticsList
    {
        if (!$this->_realTimeStatistics) {
            $this->_realTimeStatistics = new WorkersRealTimeStatisticsList($this->version, $this->solution['workspaceSid']);
        }
        return $this->_realTimeStatistics;
    }

    protected function getCumulativeStatistics(): WorkersCumulativeStatisticsList
    {
        if (!$this->_cumulativeStatistics) {
            $this->_cumulativeStatistics = new WorkersCumulativeStatisticsList($this->version, $this->solution['workspaceSid']);
        }
        return $this->_cumulativeStatistics;
    }

    protected function getStatistics(): WorkerStatisticsList
    {
        if (!$this->_statistics) {
            $this->_statistics = new WorkerStatisticsList($this->version, $this->solution['workspaceSid'], $this->solution['sid']);
        }
        return $this->_statistics;
    }

    protected function getReservations(): ReservationList
    {
        if (!$this->_reservations) {
            $this->_reservations = new ReservationList($this->version, $this->solution['workspaceSid'], $this->solution['sid']);
        }
        return $this->_reservations;
    }

    protected function getWorkerChannels(): WorkerChannelList
    {
        if (!$this->_workerChannels) {
            $this->_workerChannels = new WorkerChannelList($this->version, $this->solution['workspaceSid'], $this->solution['sid']);
        }
        return $this->_workerChannels;
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
        return '[Twilio.Taskrouter.V1.WorkerContext ' . implode(' ', $context) . ']';
    }
}