<?php

namespace Twilio\Rest\Voice\V1\ConnectionPolicy;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class ConnectionPolicyTargetPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): ConnectionPolicyTargetInstance
    {
        return new ConnectionPolicyTargetInstance($this->version, $payload, $this->solution['connectionPolicySid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Voice.V1.ConnectionPolicyTargetPage]';
    }
}