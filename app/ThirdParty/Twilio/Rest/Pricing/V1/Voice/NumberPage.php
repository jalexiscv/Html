<?php

namespace Twilio\Rest\Pricing\V1\Voice;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class NumberPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): NumberInstance
    {
        return new NumberInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Pricing.V1.NumberPage]';
    }
}