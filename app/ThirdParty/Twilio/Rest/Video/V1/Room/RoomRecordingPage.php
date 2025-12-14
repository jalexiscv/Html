<?php

namespace Twilio\Rest\Video\V1\Room;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class RoomRecordingPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): RoomRecordingInstance
    {
        return new RoomRecordingInstance($this->version, $payload, $this->solution['roomSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Video.V1.RoomRecordingPage]';
    }
}