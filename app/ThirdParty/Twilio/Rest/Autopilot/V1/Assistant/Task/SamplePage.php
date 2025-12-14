<?php

namespace Twilio\Rest\Autopilot\V1\Assistant\Task;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class SamplePage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): SampleInstance
    {
        return new SampleInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['taskSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Autopilot.V1.SamplePage]';
    }
}