<?php

namespace Twilio\Rest\Proxy\V1\Service\Session\Participant;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class MessageInteractionPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): MessageInteractionInstance
    {
        return new MessageInteractionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sessionSid'], $this->solution['participantSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Proxy.V1.MessageInteractionPage]';
    }
}