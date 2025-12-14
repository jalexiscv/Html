<?php

namespace Twilio\Rest\Studio\V1\Flow\Engagement\Step;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class StepContextPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): StepContextInstance
    {
        return new StepContextInstance($this->version, $payload, $this->solution['flowSid'], $this->solution['engagementSid'], $this->solution['stepSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V1.StepContextPage]';
    }
}