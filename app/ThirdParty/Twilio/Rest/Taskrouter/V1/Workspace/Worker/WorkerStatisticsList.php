<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use Twilio\ListResource;
use Twilio\Version;

class WorkerStatisticsList extends ListResource
{
    public function __construct(Version $version, string $workspaceSid, string $workerSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid, 'workerSid' => $workerSid,];
    }

    public function getContext(): WorkerStatisticsContext
    {
        return new WorkerStatisticsContext($this->version, $this->solution['workspaceSid'], $this->solution['workerSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.WorkerStatisticsList]';
    }
}