<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class WorkspaceCumulativeStatisticsContext extends InstanceContext
{
    public function __construct(Version $version, $workspaceSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/CumulativeStatistics';
    }

    public function fetch(array $options = []): WorkspaceCumulativeStatisticsInstance
    {
        $options = new Values($options);
        $params = Values::of(['EndDate' => Serialize::iso8601DateTime($options['endDate']), 'Minutes' => $options['minutes'], 'StartDate' => Serialize::iso8601DateTime($options['startDate']), 'TaskChannel' => $options['taskChannel'], 'SplitByWaitTime' => $options['splitByWaitTime'],]);
        $payload = $this->version->fetch('GET', $this->uri, $params);
        return new WorkspaceCumulativeStatisticsInstance($this->version, $payload, $this->solution['workspaceSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Taskrouter.V1.WorkspaceCumulativeStatisticsContext ' . implode(' ', $context) . ']';
    }
}