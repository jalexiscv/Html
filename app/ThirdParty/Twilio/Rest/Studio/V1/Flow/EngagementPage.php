<?php

namespace Twilio\Rest\Studio\V1\Flow;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class EngagementPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): EngagementInstance
    {
        return new EngagementInstance($this->version, $payload, $this->solution['flowSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V1.EngagementPage]';
    }
}