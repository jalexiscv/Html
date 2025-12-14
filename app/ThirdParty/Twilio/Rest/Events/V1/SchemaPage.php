<?php

namespace Twilio\Rest\Events\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class SchemaPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): SchemaInstance
    {
        return new SchemaInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Events.V1.SchemaPage]';
    }
}