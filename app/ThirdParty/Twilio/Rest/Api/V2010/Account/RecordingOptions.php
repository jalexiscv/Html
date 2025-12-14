<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class RecordingOptions
{
    public static function read(string $dateCreatedBefore = Values::NONE, string $dateCreated = Values::NONE, string $dateCreatedAfter = Values::NONE, string $callSid = Values::NONE, string $conferenceSid = Values::NONE): ReadRecordingOptions
    {
        return new ReadRecordingOptions($dateCreatedBefore, $dateCreated, $dateCreatedAfter, $callSid, $conferenceSid);
    }
}

class ReadRecordingOptions extends Options
{
    public function __construct(string $dateCreatedBefore = Values::NONE, string $dateCreated = Values::NONE, string $dateCreatedAfter = Values::NONE, string $callSid = Values::NONE, string $conferenceSid = Values::NONE)
    {
        $this->options['dateCreatedBefore'] = $dateCreatedBefore;
        $this->options['dateCreated'] = $dateCreated;
        $this->options['dateCreatedAfter'] = $dateCreatedAfter;
        $this->options['callSid'] = $callSid;
        $this->options['conferenceSid'] = $conferenceSid;
    }

    public function setDateCreatedBefore(string $dateCreatedBefore): self
    {
        $this->options['dateCreatedBefore'] = $dateCreatedBefore;
        return $this;
    }

    public function setDateCreated(string $dateCreated): self
    {
        $this->options['dateCreated'] = $dateCreated;
        return $this;
    }

    public function setDateCreatedAfter(string $dateCreatedAfter): self
    {
        $this->options['dateCreatedAfter'] = $dateCreatedAfter;
        return $this;
    }

    public function setCallSid(string $callSid): self
    {
        $this->options['callSid'] = $callSid;
        return $this;
    }

    public function setConferenceSid(string $conferenceSid): self
    {
        $this->options['conferenceSid'] = $conferenceSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.ReadRecordingOptions ' . $options . ']';
    }
}