<?php

namespace Twilio\Rest\Studio\V1\Flow\Execution;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class ExecutionContextPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): ExecutionContextInstance
    {
        return new ExecutionContextInstance($this->version, $payload, $this->solution['flowSid'], $this->solution['executionSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V1.ExecutionContextPage]';
    }
}