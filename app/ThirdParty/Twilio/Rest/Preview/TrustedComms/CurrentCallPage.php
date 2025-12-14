<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class CurrentCallPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): CurrentCallInstance
    {
        return new CurrentCallInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.TrustedComms.CurrentCallPage]';
    }
}