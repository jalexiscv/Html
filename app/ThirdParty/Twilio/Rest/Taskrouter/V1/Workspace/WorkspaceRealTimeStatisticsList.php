<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\ListResource;
use Twilio\Version;

class WorkspaceRealTimeStatisticsList extends ListResource
{
    public function __construct(Version $version, string $workspaceSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid,];
    }

    public function getContext(): WorkspaceRealTimeStatisticsContext
    {
        return new WorkspaceRealTimeStatisticsContext($this->version, $this->solution['workspaceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.WorkspaceRealTimeStatisticsList]';
    }
}