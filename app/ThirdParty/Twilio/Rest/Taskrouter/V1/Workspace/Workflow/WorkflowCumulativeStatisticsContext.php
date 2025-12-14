<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Workflow;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class WorkflowCumulativeStatisticsContext extends InstanceContext
{
    public function __construct(Version $version, $workspaceSid, $workflowSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid, 'workflowSid' => $workflowSid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Workflows/' . rawurlencode($workflowSid) . '/CumulativeStatistics';
    }

    public function fetch(array $options = []): WorkflowCumulativeStatisticsInstance
    {
        $options = new Values($options);
        $params = Values::of(['EndDate' => Serialize::iso8601DateTime($options['endDate']), 'Minutes' => $options['minutes'], 'StartDate' => Serialize::iso8601DateTime($options['startDate']), 'TaskChannel' => $options['taskChannel'], 'SplitByWaitTime' => $options['splitByWaitTime'],]);
        $payload = $this->version->fetch('GET', $this->uri, $params);
        return new WorkflowCumulativeStatisticsInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['workflowSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Taskrouter.V1.WorkflowCumulativeStatisticsContext ' . implode(' ', $context) . ']';
    }
}