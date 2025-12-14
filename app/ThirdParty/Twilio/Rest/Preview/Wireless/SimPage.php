<?php

namespace Twilio\Rest\Preview\Wireless;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class SimPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): SimInstance
    {
        return new SimInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Wireless.SimPage]';
    }
}