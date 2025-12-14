<?php

namespace Twilio\Rest\Proxy\V1\Service\Session;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class InteractionPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): InteractionInstance
    {
        return new InteractionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sessionSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Proxy.V1.InteractionPage]';
    }
}