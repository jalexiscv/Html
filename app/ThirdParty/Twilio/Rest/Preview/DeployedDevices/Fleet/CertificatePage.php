<?php

namespace Twilio\Rest\Preview\DeployedDevices\Fleet;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class CertificatePage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): CertificateInstance
    {
        return new CertificateInstance($this->version, $payload, $this->solution['fleetSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.DeployedDevices.CertificatePage]';
    }
}