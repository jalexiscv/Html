<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class WorkersRealTimeStatisticsPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): WorkersRealTimeStatisticsInstance
    {
        return new WorkersRealTimeStatisticsInstance($this->version, $payload, $this->solution['workspaceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.WorkersRealTimeStatisticsPage]';
    }
}