<?php

namespace Twilio\Rest\Proxy\V1\Service;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class SessionOptions
{
    public static function create(string $uniqueName = Values::NONE, DateTime $dateExpiry = Values::NONE, int $ttl = Values::NONE, string $mode = Values::NONE, string $status = Values::NONE, array $participants = Values::ARRAY_NONE, bool $failOnParticipantConflict = Values::NONE): CreateSessionOptions
    {
        return new CreateSessionOptions($uniqueName, $dateExpiry, $ttl, $mode, $status, $participants, $failOnParticipantConflict);
    }

    public static function update(DateTime $dateExpiry = Values::NONE, int $ttl = Values::NONE, string $status = Values::NONE, bool $failOnParticipantConflict = Values::NONE): UpdateSessionOptions
    {
        return new UpdateSessionOptions($dateExpiry, $ttl, $status, $failOnParticipantConflict);
    }
}

class CreateSessionOptions extends Options
{
    public function __construct(string $uniqueName = Values::NONE, DateTime $dateExpiry = Values::NONE, int $ttl = Values::NONE, string $mode = Values::NONE, string $status = Values::NONE, array $participants = Values::ARRAY_NONE, bool $failOnParticipantConflict = Values::NONE)
    {
        $this->options['uniqueName'] = $uniqueName;
        $this->options['dateExpiry'] = $dateExpiry;
        $this->options['ttl'] = $ttl;
        $this->options['mode'] = $mode;
        $this->options['status'] = $status;
        $this->options['participants'] = $participants;
        $this->options['failOnParticipantConflict'] = $failOnParticipantConflict;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setDateExpiry(DateTime $dateExpiry): self
    {
        $this->options['dateExpiry'] = $dateExpiry;
        return $this;
    }

    public function setTtl(int $ttl): self
    {
        $this->options['ttl'] = $ttl;
        return $this;
    }

    public function setMode(string $mode): self
    {
        $this->options['mode'] = $mode;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setParticipants(array $participants): self
    {
        $this->options['participants'] = $participants;
        return $this;
    }

    public function setFailOnParticipantConflict(bool $failOnParticipantConflict): self
    {
        $this->options['failOnParticipantConflict'] = $failOnParticipantConflict;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Proxy.V1.CreateSessionOptions ' . $options . ']';
    }
}

class UpdateSessionOptions extends Options
{
    public function __construct(DateTime $dateExpiry = Values::NONE, int $ttl = Values::NONE, string $status = Values::NONE, bool $failOnParticipantConflict = Values::NONE)
    {
        $this->options['dateExpiry'] = $dateExpiry;
        $this->options['ttl'] = $ttl;
        $this->options['status'] = $status;
        $this->options['failOnParticipantConflict'] = $failOnParticipantConflict;
    }

    public function setDateExpiry(DateTime $dateExpiry): self
    {
        $this->options['dateExpiry'] = $dateExpiry;
        return $this;
    }

    public function setTtl(int $ttl): self
    {
        $this->options['ttl'] = $ttl;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setFailOnParticipantConflict(bool $failOnParticipantConflict): self
    {
        $this->options['failOnParticipantConflict'] = $failOnParticipantConflict;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Proxy.V1.UpdateSessionOptions ' . $options . ']';
    }
}