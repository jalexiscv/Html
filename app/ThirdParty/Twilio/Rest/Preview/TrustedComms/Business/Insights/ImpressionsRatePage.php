<?php

namespace Twilio\Rest\Preview\TrustedComms\Business\Insights;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class ImpressionsRatePage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): ImpressionsRateInstance
    {
        return new ImpressionsRateInstance($this->version, $payload, $this->solution['businessSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.TrustedComms.ImpressionsRatePage]';
    }
}