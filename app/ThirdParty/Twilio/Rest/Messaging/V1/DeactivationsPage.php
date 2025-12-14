<?php

namespace Twilio\Rest\Messaging\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class DeactivationsPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): DeactivationsInstance
    {
        return new DeactivationsInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Messaging.V1.DeactivationsPage]';
    }
}