<?php

namespace Twilio\Rest\Preview\Understand\Assistant\Task;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class TaskStatisticsPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): TaskStatisticsInstance
    {
        return new TaskStatisticsInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['taskSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Understand.TaskStatisticsPage]';
    }
}