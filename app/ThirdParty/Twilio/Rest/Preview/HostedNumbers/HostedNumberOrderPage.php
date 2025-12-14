<?php

namespace Twilio\Rest\Preview\HostedNumbers;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class HostedNumberOrderPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): HostedNumberOrderInstance
    {
        return new HostedNumberOrderInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.HostedNumbers.HostedNumberOrderPage]';
    }
}