<?php

namespace Twilio\Rest\Autopilot\V1\Assistant;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class ModelBuildPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): ModelBuildInstance
    {
        return new ModelBuildInstance($this->version, $payload, $this->solution['assistantSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Autopilot.V1.ModelBuildPage]';
    }
}