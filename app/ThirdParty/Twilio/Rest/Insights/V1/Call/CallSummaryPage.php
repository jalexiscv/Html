<?php

namespace Twilio\Rest\Insights\V1\Call;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class CallSummaryPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): CallSummaryInstance
    {
        return new CallSummaryInstance($this->version, $payload, $this->solution['callSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Insights.V1.CallSummaryPage]';
    }
}