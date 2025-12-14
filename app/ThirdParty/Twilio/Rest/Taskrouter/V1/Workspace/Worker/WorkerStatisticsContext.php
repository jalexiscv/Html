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

class WorkerStatisticsContext extends InstanceContext
{
    public function __construct(Version $version, $workspaceSid, $workerSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid, 'workerSid' => $workerSid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Workers/' . rawurlencode($workerSid) . '/Statistics';
    }

    public function fetch(array $options = []): WorkerStatisticsInstance
    {
        $options = new Values($options);
        $params = Values::of(['Minutes' => $options['minutes'], 'StartDate' => Serialize::iso8601DateTime($options['startDate']), 'EndDate' => Serialize::iso8601DateTime($options['endDate']), 'TaskChannel' => $options['taskChannel'],]);
        $payload = $this->version->fetch('GET', $this->uri, $params);
        return new WorkerStatisticsInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['workerSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Taskrouter.V1.WorkerStatisticsContext ' . implode(' ', $context) . ']';
    }
}