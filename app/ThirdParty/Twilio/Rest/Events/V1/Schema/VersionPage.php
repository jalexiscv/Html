<?php

namespace Twilio\Rest\Events\V1\Schema;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class VersionPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): VersionInstance
    {
        return new VersionInstance($this->version, $payload, $this->solution['id']);
    }

    public function __toString(): string
    {
        return '[Twilio.Events.V1.VersionPage]';
    }
}