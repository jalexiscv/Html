<?php

namespace Twilio\Rest\Verify\V2\Service;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class RateLimitPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): RateLimitInstance
    {
        return new RateLimitInstance($this->version, $payload, $this->solution['serviceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Verify.V2.RateLimitPage]';
    }
}