<?php

namespace Twilio\Rest\Trunking\V1\Trunk;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class RecordingOptions
{
    public static function update(string $mode = Values::NONE, string $trim = Values::NONE): UpdateRecordingOptions
    {
        return new UpdateRecordingOptions($mode, $trim);
    }
}

class UpdateRecordingOptions extends Options
{
    public function __construct(string $mode = Values::NONE, string $trim = Values::NONE)
    {
        $this->options['mode'] = $mode;
        $this->options['trim'] = $trim;
    }

    public function setMode(string $mode): self
    {
        $this->options['mode'] = $mode;
        return $this;
    }

    public function setTrim(string $trim): self
    {
        $this->options['trim'] = $trim;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Trunking.V1.UpdateRecordingOptions ' . $options . ']';
    }
}