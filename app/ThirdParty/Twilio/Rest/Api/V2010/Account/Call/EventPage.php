<?php

namespace Twilio\Rest\Api\V2010\Account\Call;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class EventPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): EventInstance
    {
        return new EventInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['callSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.EventPage]';
    }
}