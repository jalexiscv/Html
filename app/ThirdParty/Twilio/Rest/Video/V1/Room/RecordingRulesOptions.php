<?php

namespace Twilio\Rest\Video\V1\Room;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class RecordingRulesOptions
{
    public static function update(array $rules = Values::ARRAY_NONE): UpdateRecordingRulesOptions
    {
        return new UpdateRecordingRulesOptions($rules);
    }
}

class UpdateRecordingRulesOptions extends Options
{
    public function __construct(array $rules = Values::ARRAY_NONE)
    {
        $this->options['rules'] = $rules;
    }

    public function setRules(array $rules): self
    {
        $this->options['rules'] = $rules;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Video.V1.UpdateRecordingRulesOptions ' . $options . ']';
    }
}