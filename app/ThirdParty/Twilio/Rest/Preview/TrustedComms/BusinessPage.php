<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class BusinessPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): BusinessInstance
    {
        return new BusinessInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.TrustedComms.BusinessPage]';
    }
}