<?php

namespace Twilio\Rest\Preview\Understand\Assistant;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class AssistantFallbackActionsOptions
{
    public static function update(array $fallbackActions = Values::ARRAY_NONE): UpdateAssistantFallbackActionsOptions
    {
        return new UpdateAssistantFallbackActionsOptions($fallbackActions);
    }
}

class UpdateAssistantFallbackActionsOptions extends Options
{
    public function __construct(array $fallbackActions = Values::ARRAY_NONE)
    {
        $this->options['fallbackActions'] = $fallbackActions;
    }

    public function setFallbackActions(array $fallbackActions): self
    {
        $this->options['fallbackActions'] = $fallbackActions;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Understand.UpdateAssistantFallbackActionsOptions ' . $options . ']';
    }
}