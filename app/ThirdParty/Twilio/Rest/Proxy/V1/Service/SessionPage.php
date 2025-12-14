<?php

namespace Twilio\Rest\Proxy\V1\Service;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class SessionPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): SessionInstance
    {
        return new SessionInstance($this->version, $payload, $this->solution['serviceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Proxy.V1.SessionPage]';
    }
}