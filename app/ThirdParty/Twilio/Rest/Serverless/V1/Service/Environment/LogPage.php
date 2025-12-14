<?php

namespace Twilio\Rest\Serverless\V1\Service\Environment;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class LogPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): LogInstance
    {
        return new LogInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['environmentSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Serverless.V1.LogPage]';
    }
}