<?php

namespace Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class VoipPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): VoipInstance
    {
        return new VoipInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['countryCode']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.VoipPage]';
    }
}