<?php

namespace Twilio\Rest\Sync\V1\Service;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class SyncMapOptions
{
    public static function create(string $uniqueName = Values::NONE, int $ttl = Values::NONE, int $collectionTtl = Values::NONE): CreateSyncMapOptions
    {
        return new CreateSyncMapOptions($uniqueName, $ttl, $collectionTtl);
    }

    public static function update(int $ttl = Values::NONE, int $collectionTtl = Values::NONE): UpdateSyncMapOptions
    {
        return new UpdateSyncMapOptions($ttl, $collectionTtl);
    }
}

class CreateSyncMapOptions extends Options
{
    public function __construct(string $uniqueName = Values::NONE, int $ttl = Values::NONE, int $collectionTtl = Values::NONE)
    {
        $this->options['uniqueName'] = $uniqueName;
        $this->options['ttl'] = $ttl;
        $this->options['collectionTtl'] = $collectionTtl;
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

    public function setCollectionTtl(int $collectionTtl): self
    {
        $this->options['collectionTtl'] = $collectionTtl;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Sync.V1.CreateSyncMapOptions ' . $options . ']';
    }
}

class UpdateSyncMapOptions extends Options
{
    public function __construct(int $ttl = Values::NONE, int $collectionTtl = Values::NONE)
    {
        $this->options['ttl'] = $ttl;
        $this->options['collectionTtl'] = $collectionTtl;
    }

    public function setTtl(int $ttl): self
    {
        $this->options['ttl'] = $ttl;
        return $this;
    }

    public function setCollectionTtl(int $collectionTtl): self
    {
        $this->options['collectionTtl'] = $collectionTtl;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Sync.V1.UpdateSyncMapOptions ' . $options . ']';
    }
}