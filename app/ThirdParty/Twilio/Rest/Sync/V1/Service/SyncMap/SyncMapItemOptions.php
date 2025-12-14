<?php

namespace Twilio\Rest\Sync\V1\Service\SyncMap;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class SyncMapItemOptions
{
    public static function delete(string $ifMatch = Values::NONE): DeleteSyncMapItemOptions
    {
        return new DeleteSyncMapItemOptions($ifMatch);
    }

    public static function create(int $ttl = Values::NONE, int $itemTtl = Values::NONE, int $collectionTtl = Values::NONE): CreateSyncMapItemOptions
    {
        return new CreateSyncMapItemOptions($ttl, $itemTtl, $collectionTtl);
    }

    public static function read(string $order = Values::NONE, string $from = Values::NONE, string $bounds = Values::NONE): ReadSyncMapItemOptions
    {
        return new ReadSyncMapItemOptions($order, $from, $bounds);
    }

    public static function update(array $data = Values::ARRAY_NONE, int $ttl = Values::NONE, int $itemTtl = Values::NONE, int $collectionTtl = Values::NONE, string $ifMatch = Values::NONE): UpdateSyncMapItemOptions
    {
        return new UpdateSyncMapItemOptions($data, $ttl, $itemTtl, $collectionTtl, $ifMatch);
    }
}

class DeleteSyncMapItemOptions extends Options
{
    public function __construct(string $ifMatch = Values::NONE)
    {
        $this->options['ifMatch'] = $ifMatch;
    }

    public function setIfMatch(string $ifMatch): self
    {
        $this->options['ifMatch'] = $ifMatch;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Sync.V1.DeleteSyncMapItemOptions ' . $options . ']';
    }
}

class CreateSyncMapItemOptions extends Options
{
    public function __construct(int $ttl = Values::NONE, int $itemTtl = Values::NONE, int $collectionTtl = Values::NONE)
    {
        $this->options['ttl'] = $ttl;
        $this->options['itemTtl'] = $itemTtl;
        $this->options['collectionTtl'] = $collectionTtl;
    }

    public function setTtl(int $ttl): self
    {
        $this->options['ttl'] = $ttl;
        return $this;
    }

    public function setItemTtl(int $itemTtl): self
    {
        $this->options['itemTtl'] = $itemTtl;
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
        return '[Twilio.Sync.V1.CreateSyncMapItemOptions ' . $options . ']';
    }
}

class ReadSyncMapItemOptions extends Options
{
    public function __construct(string $order = Values::NONE, string $from = Values::NONE, string $bounds = Values::NONE)
    {
        $this->options['order'] = $order;
        $this->options['from'] = $from;
        $this->options['bounds'] = $bounds;
    }

    public function setOrder(string $order): self
    {
        $this->options['order'] = $order;
        return $this;
    }

    public function setFrom(string $from): self
    {
        $this->options['from'] = $from;
        return $this;
    }

    public function setBounds(string $bounds): self
    {
        $this->options['bounds'] = $bounds;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Sync.V1.ReadSyncMapItemOptions ' . $options . ']';
    }
}

class UpdateSyncMapItemOptions extends Options
{
    public function __construct(array $data = Values::ARRAY_NONE, int $ttl = Values::NONE, int $itemTtl = Values::NONE, int $collectionTtl = Values::NONE, string $ifMatch = Values::NONE)
    {
        $this->options['data'] = $data;
        $this->options['ttl'] = $ttl;
        $this->options['itemTtl'] = $itemTtl;
        $this->options['collectionTtl'] = $collectionTtl;
        $this->options['ifMatch'] = $ifMatch;
    }

    public function setData(array $data): self
    {
        $this->options['data'] = $data;
        return $this;
    }

    public function setTtl(int $ttl): self
    {
        $this->options['ttl'] = $ttl;
        return $this;
    }

    public function setItemTtl(int $itemTtl): self
    {
        $this->options['itemTtl'] = $itemTtl;
        return $this;
    }

    public function setCollectionTtl(int $collectionTtl): self
    {
        $this->options['collectionTtl'] = $collectionTtl;
        return $this;
    }

    public function setIfMatch(string $ifMatch): self
    {
        $this->options['ifMatch'] = $ifMatch;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Sync.V1.UpdateSyncMapItemOptions ' . $options . ']';
    }
}