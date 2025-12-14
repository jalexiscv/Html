<?php

namespace Twilio\Rest\Pricing\V2\Voice;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class CountryPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): CountryInstance
    {
        return new CountryInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Pricing.V2.CountryPage]';
    }
}