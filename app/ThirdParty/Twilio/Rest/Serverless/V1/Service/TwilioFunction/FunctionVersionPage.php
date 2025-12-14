<?php

namespace Twilio\Rest\Serverless\V1\Service\TwilioFunction;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class FunctionVersionPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): FunctionVersionInstance
    {
        return new FunctionVersionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['functionSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Serverless.V1.FunctionVersionPage]';
    }
}