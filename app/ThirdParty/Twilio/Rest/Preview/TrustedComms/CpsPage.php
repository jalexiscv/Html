<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class CpsPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): CpsInstance
    {
        return new CpsInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.TrustedComms.CpsPage]';
    }
}