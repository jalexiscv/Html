<?php

namespace Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\AssignedAddOn;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class AssignedAddOnExtensionPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): AssignedAddOnExtensionInstance
    {
        return new AssignedAddOnExtensionInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['resourceSid'], $this->solution['assignedAddOnSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.AssignedAddOnExtensionPage]';
    }
}