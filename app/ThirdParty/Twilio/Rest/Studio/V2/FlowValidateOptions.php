<?php

namespace Twilio\Rest\Studio\V2;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class FlowValidateOptions
{
    public static function update(string $commitMessage = Values::NONE): UpdateFlowValidateOptions
    {
        return new UpdateFlowValidateOptions($commitMessage);
    }
}

class UpdateFlowValidateOptions extends Options
{
    public function __construct(string $commitMessage = Values::NONE)
    {
        $this->options['commitMessage'] = $commitMessage;
    }

    public function setCommitMessage(string $commitMessage): self
    {
        $this->options['commitMessage'] = $commitMessage;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Studio.V2.UpdateFlowValidateOptions ' . $options . ']';
    }
}