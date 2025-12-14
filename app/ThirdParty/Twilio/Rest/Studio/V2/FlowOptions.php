<?php

namespace Twilio\Rest\Studio\V2;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class FlowOptions
{
    public static function create(string $commitMessage = Values::NONE): CreateFlowOptions
    {
        return new CreateFlowOptions($commitMessage);
    }

    public static function update(string $friendlyName = Values::NONE, array $definition = Values::ARRAY_NONE, string $commitMessage = Values::NONE): UpdateFlowOptions
    {
        return new UpdateFlowOptions($friendlyName, $definition, $commitMessage);
    }
}

class CreateFlowOptions extends Options
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
        return '[Twilio.Studio.V2.CreateFlowOptions ' . $options . ']';
    }
}

class UpdateFlowOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, array $definition = Values::ARRAY_NONE, string $commitMessage = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['definition'] = $definition;
        $this->options['commitMessage'] = $commitMessage;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setDefinition(array $definition): self
    {
        $this->options['definition'] = $definition;
        return $this;
    }

    public function setCommitMessage(string $commitMessage): self
    {
        $this->options['commitMessage'] = $commitMessage;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Studio.V2.UpdateFlowOptions ' . $options . ']';
    }
}