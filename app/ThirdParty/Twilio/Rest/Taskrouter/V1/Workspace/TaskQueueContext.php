<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue\TaskQueueCumulativeStatisticsContext;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue\TaskQueueCumulativeStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue\TaskQueueRealTimeStatisticsContext;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue\TaskQueueRealTimeStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue\TaskQueueStatisticsContext;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue\TaskQueueStatisticsList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class TaskQueueContext extends InstanceContext
{
    protected $_statistics;
    protected $_realTimeStatistics;
    protected $_cumulativeStatistics;

    public function __construct(Version $version, $workspaceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid, 'sid' => $sid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/TaskQueues/' . rawurlencode($sid) . '';
    }

    public function fetch(): TaskQueueInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new TaskQueueInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['sid']);
    }

    public function update(array $options = []): TaskQueueInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'TargetWorkers' => $options['targetWorkers'], 'ReservationActivitySid' => $options['reservationActivitySid'], 'AssignmentActivitySid' => $options['assignmentActivitySid'], 'MaxReservedWorkers' => $options['maxReservedWorkers'], 'TaskOrder' => $options['taskOrder'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new TaskQueueInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getStatistics(): TaskQueueStatisticsList
    {
        if (!$this->_statistics) {
            $this->_statistics = new TaskQueueStatisticsList($this->version, $this->solution['workspaceSid'], $this->solution['sid']);
        }
        return $this->_statistics;
    }

    protected function getRealTimeStatistics(): TaskQueueRealTimeStatisticsList
    {
        if (!$this->_realTimeStatistics) {
            $this->_realTimeStatistics = new TaskQueueRealTimeStatisticsList($this->version, $this->solution['workspaceSid'], $this->solution['sid']);
        }
        return $this->_realTimeStatistics;
    }

    protected function getCumulativeStatistics(): TaskQueueCumulativeStatisticsList
    {
        if (!$this->_cumulativeStatistics) {
            $this->_cumulativeStatistics = new TaskQueueCumulativeStatisticsList($this->version, $this->solution['workspaceSid'], $this->solution['sid']);
        }
        return $this->_cumulativeStatistics;
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
        return '[Twilio.Taskrouter.V1.TaskQueueContext ' . implode(' ', $context) . ']';
    }
}