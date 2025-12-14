<?php

namespace Twilio\Rest\Insights\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class CallPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): CallInstance
    {
        return new CallInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Insights.V1.CallPage]';
    }
}