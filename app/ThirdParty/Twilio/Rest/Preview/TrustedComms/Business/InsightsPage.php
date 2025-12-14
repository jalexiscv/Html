<?php

namespace Twilio\Rest\Preview\TrustedComms\Business;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class InsightsPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): InsightsInstance
    {
        return new InsightsInstance($this->version, $payload, $this->solution['businessSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.TrustedComms.InsightsPage]';
    }
}