<?php

namespace Twilio\Rest\Supersim\V1;

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
        return '[Twilio.Supersim.V1.FleetPage]';
    }
}