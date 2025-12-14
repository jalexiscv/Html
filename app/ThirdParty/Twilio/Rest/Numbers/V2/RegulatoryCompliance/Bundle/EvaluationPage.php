<?php

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance\Bundle;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class EvaluationPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): EvaluationInstance
    {
        return new EvaluationInstance($this->version, $payload, $this->solution['bundleSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Numbers.V2.EvaluationPage]';
    }
}