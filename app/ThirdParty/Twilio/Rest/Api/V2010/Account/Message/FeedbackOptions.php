<?php

namespace Twilio\Rest\Api\V2010\Account\Message;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class FeedbackOptions
{
    public static function create(string $outcome = Values::NONE): CreateFeedbackOptions
    {
        return new CreateFeedbackOptions($outcome);
    }
}

class CreateFeedbackOptions extends Options
{
    public function __construct(string $outcome = Values::NONE)
    {
        $this->options['outcome'] = $outcome;
    }

    public function setOutcome(string $outcome): self
    {
        $this->options['outcome'] = $outcome;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.CreateFeedbackOptions ' . $options . ']';
    }
}