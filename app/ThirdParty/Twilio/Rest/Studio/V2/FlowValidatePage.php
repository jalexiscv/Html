<?php

namespace Twilio\Rest\Studio\V2;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class FlowValidatePage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): FlowValidateInstance
    {
        return new FlowValidateInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V2.FlowValidatePage]';
    }
}