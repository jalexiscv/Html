<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class WorkerPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): WorkerInstance
    {
        return new WorkerInstance($this->version, $payload, $this->solution['workspaceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.WorkerPage]';
    }
}