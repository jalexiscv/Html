<?php

namespace Twilio\Rest\Insights\V1;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class RoomOptions
{
    public static function read(array $roomType = Values::ARRAY_NONE, array $codec = Values::ARRAY_NONE, string $roomName = Values::NONE, DateTime $createdAfter = Values::NONE, DateTime $createdBefore = Values::NONE): ReadRoomOptions
    {
        return new ReadRoomOptions($roomType, $codec, $roomName, $createdAfter, $createdBefore);
    }
}

class ReadRoomOptions extends Options
{
    public function __construct(array $roomType = Values::ARRAY_NONE, array $codec = Values::ARRAY_NONE, string $roomName = Values::NONE, DateTime $createdAfter = Values::NONE, DateTime $createdBefore = Values::NONE)
    {
        $this->options['roomType'] = $roomType;
        $this->options['codec'] = $codec;
        $this->options['roomName'] = $roomName;
        $this->options['createdAfter'] = $createdAfter;
        $this->options['createdBefore'] = $createdBefore;
    }

    public function setRoomType(array $roomType): self
    {
        $this->options['roomType'] = $roomType;
        return $this;
    }

    public function setCodec(array $codec): self
    {
        $this->options['codec'] = $codec;
        return $this;
    }

    public function setRoomName(string $roomName): self
    {
        $this->options['roomName'] = $roomName;
        return $this;
    }

    public function setCreatedAfter(DateTime $createdAfter): self
    {
        $this->options['createdAfter'] = $createdAfter;
        return $this;
    }

    public function setCreatedBefore(DateTime $createdBefore): self
    {
        $this->options['createdBefore'] = $createdBefore;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Insights.V1.ReadRoomOptions ' . $options . ']';
    }
}