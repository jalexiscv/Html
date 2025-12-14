<?php

namespace Twilio\Rest\Preview\Wireless;

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
        return '[Twilio.Preview.Wireless.CommandPage]';
    }
}