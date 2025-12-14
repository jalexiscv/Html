<?php

namespace Twilio\Rest\Studio\V2;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class FlowPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): FlowInstance
    {
        return new FlowInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V2.FlowPage]';
    }
}