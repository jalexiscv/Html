<?php

namespace Twilio\Rest\Sync\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class ServicePage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): ServiceInstance
    {
        return new ServiceInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Sync.V1.ServicePage]';
    }
}