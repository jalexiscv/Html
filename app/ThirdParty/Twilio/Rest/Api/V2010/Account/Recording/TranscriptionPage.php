<?php

namespace Twilio\Rest\Api\V2010\Account\Recording;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class TranscriptionPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): TranscriptionInstance
    {
        return new TranscriptionInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['recordingSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.TranscriptionPage]';
    }
}