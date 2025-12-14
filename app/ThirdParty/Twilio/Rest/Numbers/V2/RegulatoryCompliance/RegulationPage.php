<?php

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class RegulationPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): RegulationInstance
    {
        return new RegulationInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Numbers.V2.RegulationPage]';
    }
}