<?php

namespace Twilio\Rest\Video\V1;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class RecordingOptions
{
    public static function read(string $status = Values::NONE, string $sourceSid = Values::NONE, array $groupingSid = Values::ARRAY_NONE, DateTime $dateCreatedAfter = Values::NONE, DateTime $dateCreatedBefore = Values::NONE, string $mediaType = Values::NONE): ReadRecordingOptions
    {
        return new ReadRecordingOptions($status, $sourceSid, $groupingSid, $dateCreatedAfter, $dateCreatedBefore, $mediaType);
    }
}

class ReadRecordingOptions extends Options
{
    public function __construct(string $status = Values::NONE, string $sourceSid = Values::NONE, array $groupingSid = Values::ARRAY_NONE, DateTime $dateCreatedAfter = Values::NONE, DateTime $dateCreatedBefore = Values::NONE, string $mediaType = Values::NONE)
    {
        $this->options['status'] = $status;
        $this->options['sourceSid'] = $sourceSid;
        $this->options['groupingSid'] = $groupingSid;
        $this->options['dateCreatedAfter'] = $dateCreatedAfter;
        $this->options['dateCreatedBefore'] = $dateCreatedBefore;
        $this->options['mediaType'] = $mediaType;
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

    public function setGroupingSid(array $groupingSid): self
    {
        $this->options['groupingSid'] = $groupingSid;
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

    public function setMediaType(string $mediaType): self
    {
        $this->options['mediaType'] = $mediaType;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Video.V1.ReadRecordingOptions ' . $options . ']';
    }
}