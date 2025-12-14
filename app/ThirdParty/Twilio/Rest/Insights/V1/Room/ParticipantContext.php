<?php

namespace Twilio\Rest\Insights\V1\Room;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class ParticipantContext extends InstanceContext
{
    public function __construct(Version $version, $roomSid, $participantSid)
    {
        parent::__construct($version);
        $this->solution = ['roomSid' => $roomSid, 'participantSid' => $participantSid,];
        $this->uri = '/Video/Rooms/' . rawurlencode($roomSid) . '/Participants/' . rawurlencode($participantSid) . '';
    }

    public function fetch(): ParticipantInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ParticipantInstance($this->version, $payload, $this->solution['roomSid'], $this->solution['participantSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Insights.V1.ParticipantContext ' . implode(' ', $context) . ']';
    }
}