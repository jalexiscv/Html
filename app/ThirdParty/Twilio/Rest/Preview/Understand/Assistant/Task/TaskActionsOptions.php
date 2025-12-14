<?php

namespace Twilio\Rest\Preview\Understand\Assistant\Task;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class TaskActionsOptions
{
    public static function update(array $actions = Values::ARRAY_NONE): UpdateTaskActionsOptions
    {
        return new UpdateTaskActionsOptions($actions);
    }
}

class UpdateTaskActionsOptions extends Options
{
    public function __construct(array $actions = Values::ARRAY_NONE)
    {
        $this->options['actions'] = $actions;
    }

    public function setActions(array $actions): self
    {
        $this->options['actions'] = $actions;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Understand.UpdateTaskActionsOptions ' . $options . ']';
    }
}