<?php

namespace Twilio\Rest\Studio\V1\Flow\Engagement;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class StepPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): StepInstance
    {
        return new StepInstance($this->version, $payload, $this->solution['flowSid'], $this->solution['engagementSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V1.StepPage]';
    }
}