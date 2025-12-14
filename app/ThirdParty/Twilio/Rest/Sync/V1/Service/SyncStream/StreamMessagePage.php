<?php

namespace Twilio\Rest\Sync\V1\Service\SyncStream;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class StreamMessagePage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): StreamMessageInstance
    {
        return new StreamMessageInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['streamSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Sync.V1.StreamMessagePage]';
    }
}