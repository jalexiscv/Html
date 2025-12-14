<?php

namespace Twilio\Rest\Studio\V1\Flow\Execution\ExecutionStep;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class ExecutionStepContextPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): ExecutionStepContextInstance
    {
        return new ExecutionStepContextInstance($this->version, $payload, $this->solution['flowSid'], $this->solution['executionSid'], $this->solution['stepSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V1.ExecutionStepContextPage]';
    }
}