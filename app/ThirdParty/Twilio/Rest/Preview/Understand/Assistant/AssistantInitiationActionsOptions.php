<?php

namespace Twilio\Rest\Preview\Understand\Assistant;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class AssistantInitiationActionsOptions
{
    public static function update(array $initiationActions = Values::ARRAY_NONE): UpdateAssistantInitiationActionsOptions
    {
        return new UpdateAssistantInitiationActionsOptions($initiationActions);
    }
}

class UpdateAssistantInitiationActionsOptions extends Options
{
    public function __construct(array $initiationActions = Values::ARRAY_NONE)
    {
        $this->options['initiationActions'] = $initiationActions;
    }

    public function setInitiationActions(array $initiationActions): self
    {
        $this->options['initiationActions'] = $initiationActions;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Understand.UpdateAssistantInitiationActionsOptions ' . $options . ']';
    }
}