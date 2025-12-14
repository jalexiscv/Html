<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class OutgoingCallerIdPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): OutgoingCallerIdInstance
    {
        return new OutgoingCallerIdInstance($this->version, $payload, $this->solution['accountSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.OutgoingCallerIdPage]';
    }
}