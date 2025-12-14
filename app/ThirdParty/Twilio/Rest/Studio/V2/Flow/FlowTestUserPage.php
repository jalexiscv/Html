<?php

namespace Twilio\Rest\Studio\V2\Flow;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class FlowTestUserPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): FlowTestUserInstance
    {
        return new FlowTestUserInstance($this->version, $payload, $this->solution['sid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V2.FlowTestUserPage]';
    }
}