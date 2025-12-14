<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class WorkersStatisticsContext extends InstanceContext
{
    public function __construct(Version $version, $workspaceSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Workers/Statistics';
    }

    public function fetch(array $options = []): WorkersStatisticsInstance
    {
        $options = new Values($options);
        $params = Values::of(['Minutes' => $options['minutes'], 'StartDate' => Serialize::iso8601DateTime($options['startDate']), 'EndDate' => Serialize::iso8601DateTime($options['endDate']), 'TaskQueueSid' => $options['taskQueueSid'], 'TaskQueueName' => $options['taskQueueName'], 'FriendlyName' => $options['friendlyName'], 'TaskChannel' => $options['taskChannel'],]);
        $payload = $this->version->fetch('GET', $this->uri, $params);
        return new WorkersStatisticsInstance($this->version, $payload, $this->solution['workspaceSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Taskrouter.V1.WorkersStatisticsContext ' . implode(' ', $context) . ']';
    }
}