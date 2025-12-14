<?php

namespace Twilio\Rest\Serverless\V1\Service;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class BuildPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): BuildInstance
    {
        return new BuildInstance($this->version, $payload, $this->solution['serviceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Serverless.V1.BuildPage]';
    }
}