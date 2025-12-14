<?php

namespace Twilio\Rest\Preview\Sync\Service\SyncList;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class SyncListItemOptions
{
    public static function delete(string $ifMatch = Values::NONE): DeleteSyncListItemOptions
    {
        return new DeleteSyncListItemOptions($ifMatch);
    }

    public static function read(string $order = Values::NONE, string $from = Values::NONE, string $bounds = Values::NONE): ReadSyncListItemOptions
    {
        return new ReadSyncListItemOptions($order, $from, $bounds);
    }

    public static function update(string $ifMatch = Values::NONE): UpdateSyncListItemOptions
    {
        return new UpdateSyncListItemOptions($ifMatch);
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
        return '[Twilio.Preview.Sync.DeleteSyncListItemOptions ' . $options . ']';
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
        return '[Twilio.Preview.Sync.ReadSyncListItemOptions ' . $options . ']';
    }
}

class UpdateSyncListItemOptions extends Options
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
        return '[Twilio.Preview.Sync.UpdateSyncListItemOptions ' . $options . ']';
    }
}