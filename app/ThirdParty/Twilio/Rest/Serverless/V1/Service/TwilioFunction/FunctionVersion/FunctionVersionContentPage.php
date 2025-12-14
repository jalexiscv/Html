<?php

namespace Twilio\Rest\Serverless\V1\Service\TwilioFunction\FunctionVersion;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class FunctionVersionContentPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): FunctionVersionContentInstance
    {
        return new FunctionVersionContentInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['functionSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Serverless.V1.FunctionVersionContentPage]';
    }
}