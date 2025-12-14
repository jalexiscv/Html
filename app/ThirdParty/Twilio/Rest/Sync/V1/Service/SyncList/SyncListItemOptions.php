<?php

namespace Twilio\Rest\Sync\V1\Service\SyncList;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class SyncListItemOptions
{
    public static function delete(string $ifMatch = Values::NONE): DeleteSyncListItemOptions
    {
        return new DeleteSyncListItemOptions($ifMatch);
    }

    public static function create(int $ttl = Values::NONE, int $itemTtl = Values::NONE, int $collectionTtl = Values::NONE): CreateSyncListItemOptions
    {
        return new CreateSyncListItemOptions($ttl, $itemTtl, $collectionTtl);
    }

    public static function read(string $order = Values::NONE, string $from = Values::NONE, string $bounds = Values::NONE): ReadSyncListItemOptions
    {
        return new ReadSyncListItemOptions($order, $from, $bounds);
    }

    public static function update(array $data = Values::ARRAY_NONE, int $ttl = Values::NONE, int $itemTtl = Values::NONE, int $collectionTtl = Values::NONE, string $ifMatch = Values::NONE): UpdateSyncListItemOptions
    {
        return new UpdateSyncListItemOptions($data, $ttl, $itemTtl, $collectionTtl, $ifMatch);
    }
}

class DeleteSyncListItemOptions extends Options
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
        return '[Twilio.Sync.V1.DeleteSyncListItemOptions ' . $options . ']';
    }
}

class CreateSyncListItemOptions extends Options
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
        return '[Twilio.Sync.V1.CreateSyncListItemOptions ' . $options . ']';
    }
}

class ReadSyncListItemOptions extends Options
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
        return '[Twilio.Sync.V1.ReadSyncListItemOptions ' . $options . ']';
    }
}

class UpdateSyncListItemOptions extends Options
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
        return '[Twilio.Sync.V1.UpdateSyncListItemOptions ' . $options . ']';
    }
}