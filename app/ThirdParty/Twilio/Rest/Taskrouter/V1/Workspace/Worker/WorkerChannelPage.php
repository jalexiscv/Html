<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class WorkerChannelPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): WorkerChannelInstance
    {
        return new WorkerChannelInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['workerSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.WorkerChannelPage]';
    }
}