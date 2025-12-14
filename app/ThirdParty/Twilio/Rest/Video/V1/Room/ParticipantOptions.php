<?php

namespace Twilio\Rest\Video\V1\Room;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ParticipantOptions
{
    public static function read(string $status = Values::NONE, string $identity = Values::NONE, DateTime $dateCreatedAfter = Values::NONE, DateTime $dateCreatedBefore = Values::NONE): ReadParticipantOptions
    {
        return new ReadParticipantOptions($status, $identity, $dateCreatedAfter, $dateCreatedBefore);
    }

    public static function update(string $status = Values::NONE): UpdateParticipantOptions
    {
        return new UpdateParticipantOptions($status);
    }
}

class ReadParticipantOptions extends Options
{
    public function __construct(string $status = Values::NONE, string $identity = Values::NONE, DateTime $dateCreatedAfter = Values::NONE, DateTime $dateCreatedBefore = Values::NONE)
    {
        $this->options['status'] = $status;
        $this->options['identity'] = $identity;
        $this->options['dateCreatedAfter'] = $dateCreatedAfter;
        $this->options['dateCreatedBefore'] = $dateCreatedBefore;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setIdentity(string $identity): self
    {
        $this->options['identity'] = $identity;
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
        return '[Twilio.Video.V1.ReadParticipantOptions ' . $options . ']';
    }
}

class UpdateParticipantOptions extends Options
{
    public function __construct(string $status = Values::NONE)
    {
        $this->options['status'] = $status;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Video.V1.UpdateParticipantOptions ' . $options . ']';
    }
}