<?php

namespace Twilio\Rest\Lookups\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class PhoneNumberPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): PhoneNumberInstance
    {
        return new PhoneNumberInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Lookups.V1.PhoneNumberPage]';
    }
}