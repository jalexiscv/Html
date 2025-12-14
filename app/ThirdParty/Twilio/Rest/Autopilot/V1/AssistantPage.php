<?php

namespace Twilio\Rest\Autopilot\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class AssistantPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): AssistantInstance
    {
        return new AssistantInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Autopilot.V1.AssistantPage]';
    }
}