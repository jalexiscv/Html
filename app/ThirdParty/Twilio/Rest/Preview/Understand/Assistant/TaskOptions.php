<?php

namespace Twilio\Rest\Preview\Understand\Assistant;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class TaskOptions
{
    public static function create(string $friendlyName = Values::NONE, array $actions = Values::ARRAY_NONE, string $actionsUrl = Values::NONE): CreateTaskOptions
    {
        return new CreateTaskOptions($friendlyName, $actions, $actionsUrl);
    }

    public static function update(string $friendlyName = Values::NONE, string $uniqueName = Values::NONE, array $actions = Values::ARRAY_NONE, string $actionsUrl = Values::NONE): UpdateTaskOptions
    {
        return new UpdateTaskOptions($friendlyName, $uniqueName, $actions, $actionsUrl);
    }
}

class CreateTaskOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, array $actions = Values::ARRAY_NONE, string $actionsUrl = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['actions'] = $actions;
        $this->options['actionsUrl'] = $actionsUrl;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setActions(array $actions): self
    {
        $this->options['actions'] = $actions;
        return $this;
    }

    public function setActionsUrl(string $actionsUrl): self
    {
        $this->options['actionsUrl'] = $actionsUrl;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Understand.CreateTaskOptions ' . $options . ']';
    }
}

class UpdateTaskOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $uniqueName = Values::NONE, array $actions = Values::ARRAY_NONE, string $actionsUrl = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['uniqueName'] = $uniqueName;
        $this->options['actions'] = $actions;
        $this->options['actionsUrl'] = $actionsUrl;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setActions(array $actions): self
    {
        $this->options['actions'] = $actions;
        return $this;
    }

    public function setActionsUrl(string $actionsUrl): self
    {
        $this->options['actionsUrl'] = $actionsUrl;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Understand.UpdateTaskOptions ' . $options . ']';
    }
}