<?php

namespace Twilio\Rest\Video\V1\Room;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class RoomRecordingOptions
{
    public static function read(string $status = Values::NONE, string $sourceSid = Values::NONE, DateTime $dateCreatedAfter = Values::NONE, DateTime $dateCreatedBefore = Values::NONE): ReadRoomRecordingOptions
    {
        return new ReadRoomRecordingOptions($status, $sourceSid, $dateCreatedAfter, $dateCreatedBefore);
    }
}

class ReadRoomRecordingOptions extends Options
{
    public function __construct(string $status = Values::NONE, string $sourceSid = Values::NONE, DateTime $dateCreatedAfter = Values::NONE, DateTime $dateCreatedBefore = Values::NONE)
    {
        $this->options['status'] = $status;
        $this->options['sourceSid'] = $sourceSid;
        $this->options['dateCreatedAfter'] = $dateCreatedAfter;
        $this->options['dateCreatedBefore'] = $dateCreatedBefore;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setSourceSid(string $sourceSid): self
    {
        $this->options['sourceSid'] = $sourceSid;
        return $this;
    }

    public function setDateCreatedAfter(DateTime $dateCreatedAfter): self
    {
        $this->options['dateCreatedAfter'] = $dateCreatedAfter;
        return $this;
    }

    public function setDateCreatedBefore(DateTime $dateCreatedBefore): self
    {
        $this->options['dateCreatedBefore'] = $dateCreatedBefore;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Video.V1.ReadRoomRecordingOptions ' . $options . ']';
    }
}