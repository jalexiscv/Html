<?php

namespace Twilio\Rest\Video\V1\Room\Participant;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class PublishedTrackPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): PublishedTrackInstance
    {
        return new PublishedTrackInstance($this->version, $payload, $this->solution['roomSid'], $this->solution['participantSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Video.V1.PublishedTrackPage]';
    }
}