<?php

namespace Twilio\Rest\Api\V2010\Account\Conference;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class ParticipantPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): ParticipantInstance
    {
        return new ParticipantInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['conferenceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.ParticipantPage]';
    }
}