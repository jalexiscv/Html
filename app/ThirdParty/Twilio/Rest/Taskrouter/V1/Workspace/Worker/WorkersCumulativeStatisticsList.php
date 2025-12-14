<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use Twilio\ListResource;
use Twilio\Version;

class WorkersCumulativeStatisticsList extends ListResource
{
    public function __construct(Version $version, string $workspaceSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid,];
    }

    public function getContext(): WorkersCumulativeStatisticsContext
    {
        return new WorkersCumulativeStatisticsContext($this->version, $this->solution['workspaceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.WorkersCumulativeStatisticsList]';
    }
}