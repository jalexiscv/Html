<?php

namespace Twilio\Rest\Voice\V1\DialingPermissions\Country;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class HighriskSpecialPrefixPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): HighriskSpecialPrefixInstance
    {
        return new HighriskSpecialPrefixInstance($this->version, $payload, $this->solution['isoCode']);
    }

    public function __toString(): string
    {
        return '[Twilio.Voice.V1.HighriskSpecialPrefixPage]';
    }
}