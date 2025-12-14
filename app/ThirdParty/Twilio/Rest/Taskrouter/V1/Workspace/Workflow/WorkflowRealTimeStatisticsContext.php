<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Workflow;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class WorkflowRealTimeStatisticsContext extends InstanceContext
{
    public function __construct(Version $version, $workspaceSid, $workflowSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid, 'workflowSid' => $workflowSid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Workflows/' . rawurlencode($workflowSid) . '/RealTimeStatistics';
    }

    public function fetch(array $options = []): WorkflowRealTimeStatisticsInstance
    {
        $options = new Values($options);
        $params = Values::of(['TaskChannel' => $options['taskChannel'],]);
        $payload = $this->version->fetch('GET', $this->uri, $params);
        return new WorkflowRealTimeStatisticsInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['workflowSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Taskrouter.V1.WorkflowRealTimeStatisticsContext ' . implode(' ', $context) . ']';
    }
}