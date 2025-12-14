<?php

namespace Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class AssignedAddOnPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): AssignedAddOnInstance
    {
        return new AssignedAddOnInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['resourceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.AssignedAddOnPage]';
    }
}