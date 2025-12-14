<?php

namespace Twilio\Rest\Video\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class RecordingPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): RecordingInstance
    {
        return new RecordingInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Video.V1.RecordingPage]';
    }
}