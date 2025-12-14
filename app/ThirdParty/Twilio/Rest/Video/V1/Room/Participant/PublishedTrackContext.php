<?php

namespace Twilio\Rest\Video\V1\Room\Participant;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class PublishedTrackContext extends InstanceContext
{
    public function __construct(Version $version, $roomSid, $participantSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['roomSid' => $roomSid, 'participantSid' => $participantSid, 'sid' => $sid,];
        $this->uri = '/Rooms/' . rawurlencode($roomSid) . '/Participants/' . rawurlencode($participantSid) . '/PublishedTracks/' . rawurlencode($sid) . '';
    }

    public function fetch(): PublishedTrackInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new PublishedTrackInstance($this->version, $payload, $this->solution['roomSid'], $this->solution['participantSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Video.V1.PublishedTrackContext ' . implode(' ', $context) . ']';
    }
}