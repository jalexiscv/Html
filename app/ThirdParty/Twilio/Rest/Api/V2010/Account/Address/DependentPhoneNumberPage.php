<?php

namespace Twilio\Rest\Api\V2010\Account\Address;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class DependentPhoneNumberPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): DependentPhoneNumberInstance
    {
        return new DependentPhoneNumberInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['addressSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.DependentPhoneNumberPage]';
    }
}