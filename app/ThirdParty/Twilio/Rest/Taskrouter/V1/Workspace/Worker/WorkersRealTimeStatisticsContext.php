<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class WorkersRealTimeStatisticsContext extends InstanceContext
{
    public function __construct(Version $version, $workspaceSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Workers/RealTimeStatistics';
    }

    public function fetch(array $options = []): WorkersRealTimeStatisticsInstance
    {
        $options = new Values($options);
        $params = Values::of(['TaskChannel' => $options['taskChannel'],]);
        $payload = $this->version->fetch('GET', $this->uri, $params);
        return new WorkersRealTimeStatisticsInstance($this->version, $payload, $this->solution['workspaceSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Taskrouter.V1.WorkersRealTimeStatisticsContext ' . implode(' ', $context) . ']';
    }
}