<?php

namespace Twilio\Rest\Sync\V1\Service;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class SyncStreamOptions
{
    public static function create(string $uniqueName = Values::NONE, int $ttl = Values::NONE): CreateSyncStreamOptions
    {
        return new CreateSyncStreamOptions($uniqueName, $ttl);
    }

    public static function update(int $ttl = Values::NONE): UpdateSyncStreamOptions
    {
        return new UpdateSyncStreamOptions($ttl);
    }
}

class CreateSyncStreamOptions extends Options
{
    public function __construct(string $uniqueName = Values::NONE, int $ttl = Values::NONE)
    {
        $this->options['uniqueName'] = $uniqueName;
        $this->options['ttl'] = $ttl;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setTtl(int $ttl): self
    {
        $this->options['ttl'] = $ttl;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Sync.V1.CreateSyncStreamOptions ' . $options . ']';
    }
}

class UpdateSyncStreamOptions extends Options
{
    public function __construct(int $ttl = Values::NONE)
    {
        $this->options['ttl'] = $ttl;
    }

    public function setTtl(int $ttl): self
    {
        $this->options['ttl'] = $ttl;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Sync.V1.UpdateSyncStreamOptions ' . $options . ']';
    }
}