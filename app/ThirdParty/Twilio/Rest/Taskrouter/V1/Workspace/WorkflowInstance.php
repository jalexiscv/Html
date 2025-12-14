<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Taskrouter\V1\Workspace\Workflow\WorkflowCumulativeStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\Workflow\WorkflowRealTimeStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\Workflow\WorkflowStatisticsList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class WorkflowInstance extends InstanceResource
{
    protected $_statistics;
    protected $_realTimeStatistics;
    protected $_cumulativeStatistics;

    public function __construct(Version $version, array $payload, string $workspaceSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'assignmentCallbackUrl' => Values::array_get($payload, 'assignment_callback_url'), 'configuration' => Values::array_get($payload, 'configuration'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'documentContentType' => Values::array_get($payload, 'document_content_type'), 'fallbackAssignmentCallbackUrl' => Values::array_get($payload, 'fallback_assignment_callback_url'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'sid' => Values::array_get($payload, 'sid'), 'taskReservationTimeout' => Values::array_get($payload, 'task_reservation_timeout'), 'workspaceSid' => Values::array_get($payload, 'workspace_sid'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['workspaceSid' => $workspaceSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): WorkflowContext
    {
        if (!$this->context) {
            $this->context = new WorkflowContext($this->version, $this->solution['workspaceSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): WorkflowInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): WorkflowInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getStatistics(): WorkflowStatisticsList
    {
        return $this->proxy()->statistics;
    }

    protected function getRealTimeStatistics(): WorkflowRealTimeStatisticsList
    {
        return $this->proxy()->realTimeStatistics;
    }

    protected function getCumulativeStatistics(): WorkflowCumulativeStatisticsList
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
        return '[Twilio.Taskrouter.V1.WorkflowInstance ' . implode(' ', $context) . ']';
    }
}