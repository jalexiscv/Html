<?php

namespace Twilio\Rest\Wireless\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class CommandPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): CommandInstance
    {
        return new CommandInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Wireless.V1.CommandPage]';
    }
}