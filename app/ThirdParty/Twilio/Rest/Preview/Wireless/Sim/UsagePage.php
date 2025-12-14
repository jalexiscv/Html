<?php

namespace Twilio\Rest\Preview\Wireless\Sim;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class UsagePage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): UsageInstance
    {
        return new UsageInstance($this->version, $payload, $this->solution['simSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Wireless.UsagePage]';
    }
}