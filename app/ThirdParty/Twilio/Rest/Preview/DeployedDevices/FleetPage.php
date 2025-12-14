<?php

namespace Twilio\Rest\Preview\DeployedDevices;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class FleetPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): FleetInstance
    {
        return new FleetInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.DeployedDevices.FleetPage]';
    }
}