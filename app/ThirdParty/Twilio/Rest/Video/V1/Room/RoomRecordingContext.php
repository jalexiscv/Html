<?php

namespace Twilio\Rest\Video\V1\Room;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class RoomRecordingContext extends InstanceContext
{
    public function __construct(Version $version, $roomSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['roomSid' => $roomSid, 'sid' => $sid,];
        $this->uri = '/Rooms/' . rawurlencode($roomSid) . '/Recordings/' . rawurlencode($sid) . '';
    }

    public function fetch(): RoomRecordingInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new RoomRecordingInstance($this->version, $payload, $this->solution['roomSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Video.V1.RoomRecordingContext ' . implode(' ', $context) . ']';
    }
}