<?php

namespace Twilio\Rest\Video\V1\Room\Participant;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class SubscribedTrackContext extends InstanceContext
{
    public function __construct(Version $version, $roomSid, $participantSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['roomSid' => $roomSid, 'participantSid' => $participantSid, 'sid' => $sid,];
        $this->uri = '/Rooms/' . rawurlencode($roomSid) . '/Participants/' . rawurlencode($participantSid) . '/SubscribedTracks/' . rawurlencode($sid) . '';
    }

    public function fetch(): SubscribedTrackInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SubscribedTrackInstance($this->version, $payload, $this->solution['roomSid'], $this->solution['participantSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Video.V1.SubscribedTrackContext ' . implode(' ', $context) . ']';
    }
}