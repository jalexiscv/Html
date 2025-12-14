<?php

namespace Twilio\Rest\Monitor\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class AlertPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): AlertInstance
    {
        return new AlertInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Monitor.V1.AlertPage]';
    }
}