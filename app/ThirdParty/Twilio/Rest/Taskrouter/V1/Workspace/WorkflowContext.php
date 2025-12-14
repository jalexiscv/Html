<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Taskrouter\V1\Workspace\Workflow\WorkflowCumulativeStatisticsContext;
use Twilio\Rest\Taskrouter\V1\Workspace\Workflow\WorkflowCumulativeStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\Workflow\WorkflowRealTimeStatisticsContext;
use Twilio\Rest\Taskrouter\V1\Workspace\Workflow\WorkflowRealTimeStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\Workflow\WorkflowStatisticsContext;
use Twilio\Rest\Taskrouter\V1\Workspace\Workflow\WorkflowStatisticsList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class WorkflowContext extends InstanceContext
{
    protected $_statistics;
    protected $_realTimeStatistics;
    protected $_cumulativeStatistics;

    public function __construct(Version $version, $workspaceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid, 'sid' => $sid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Workflows/' . rawurlencode($sid) . '';
    }

    public function fetch(): WorkflowInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new WorkflowInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['sid']);
    }

    public function update(array $options = []): WorkflowInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'AssignmentCallbackUrl' => $options['assignmentCallbackUrl'], 'FallbackAssignmentCallbackUrl' => $options['fallbackAssignmentCallbackUrl'], 'Configuration' => $options['configuration'], 'TaskReservationTimeout' => $options['taskReservationTimeout'], 'ReEvaluateTasks' => $options['reEvaluateTasks'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new WorkflowInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getStatistics(): WorkflowStatisticsList
    {
        if (!$this->_statistics) {
            $this->_statistics = new WorkflowStatisticsList($this->version, $this->solution['workspaceSid'], $this->solution['sid']);
        }
        return $this->_statistics;
    }

    protected function getRealTimeStatistics(): WorkflowRealTimeStatisticsList
    {
        if (!$this->_realTimeStatistics) {
            $this->_realTimeStatistics = new WorkflowRealTimeStatisticsList($this->version, $this->solution['workspaceSid'], $this->solution['sid']);
        }
        return $this->_realTimeStatistics;
    }

    protected function getCumulativeStatistics(): WorkflowCumulativeStatisticsList
    {
        if (!$this->_cumulativeStatistics) {
            $this->_cumulativeStatistics = new WorkflowCumulativeStatisticsList($this->version, $this->solution['workspaceSid'], $this->solution['sid']);
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
        return '[Twilio.Taskrouter.V1.WorkflowContext ' . implode(' ', $context) . ']';
    }
}