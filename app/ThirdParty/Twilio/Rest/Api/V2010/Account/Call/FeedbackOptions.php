<?php

namespace Twilio\Rest\Api\V2010\Account\Call;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class FeedbackOptions
{
    public static function create(array $issue = Values::ARRAY_NONE): CreateFeedbackOptions
    {
        return new CreateFeedbackOptions($issue);
    }

    public static function update(array $issue = Values::ARRAY_NONE): UpdateFeedbackOptions
    {
        return new UpdateFeedbackOptions($issue);
    }
}

class CreateFeedbackOptions extends Options
{
    public function __construct(array $issue = Values::ARRAY_NONE)
    {
        $this->options['issue'] = $issue;
    }

    public function setIssue(array $issue): self
    {
        $this->options['issue'] = $issue;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.CreateFeedbackOptions ' . $options . ']';
    }
}

class UpdateFeedbackOptions extends Options
{
    public function __construct(array $issue = Values::ARRAY_NONE)
    {
        $this->options['issue'] = $issue;
    }

    public function setIssue(array $issue): self
    {
        $this->options['issue'] = $issue;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.UpdateFeedbackOptions ' . $options . ']';
    }
}