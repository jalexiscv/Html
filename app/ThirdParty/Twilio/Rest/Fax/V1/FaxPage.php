<?php

namespace Twilio\Rest\Fax\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class FaxPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): FaxInstance
    {
        return new FaxInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Fax.V1.FaxPage]';
    }
}