<?php

namespace Twilio\Rest\FlexApi\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class FlexFlowPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): FlexFlowInstance
    {
        return new FlexFlowInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.FlexApi.V1.FlexFlowPage]';
    }
}