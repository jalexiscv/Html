<?php

namespace Twilio\Rest\Verify\V2\Service\RateLimit;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class BucketPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): BucketInstance
    {
        return new BucketInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['rateLimitSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Verify.V2.BucketPage]';
    }
}