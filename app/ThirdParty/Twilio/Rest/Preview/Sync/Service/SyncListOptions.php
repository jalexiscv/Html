<?php

namespace Twilio\Rest\Preview\Sync\Service;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class SyncListOptions
{
    public static function create(string $uniqueName = Values::NONE): CreateSyncListOptions
    {
        return new CreateSyncListOptions($uniqueName);
    }
}

class CreateSyncListOptions extends Options
{
    public function __construct(string $uniqueName = Values::NONE)
    {
        $this->options['uniqueName'] = $uniqueName;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Sync.CreateSyncListOptions ' . $options . ']';
    }
}