<?php

namespace Twilio\Rest\Preview\Understand\Assistant;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class TaskPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): TaskInstance
    {
        return new TaskInstance($this->version, $payload, $this->solution['assistantSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Understand.TaskPage]';
    }
}