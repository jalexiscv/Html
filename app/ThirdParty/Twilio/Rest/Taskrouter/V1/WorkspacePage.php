<?php

namespace Twilio\Rest\Taskrouter\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class WorkspacePage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): WorkspaceInstance
    {
        return new WorkspaceInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.WorkspacePage]';
    }
}