<?php

namespace Twilio\Rest\Pricing\V2;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class VoicePage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): VoiceInstance
    {
        return new VoiceInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Pricing.V2.VoicePage]';
    }
}