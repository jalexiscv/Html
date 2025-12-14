<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class TaskOptions
{
    public static function update(string $attributes = Values::NONE, string $assignmentStatus = Values::NONE, string $reason = Values::NONE, int $priority = Values::NONE, string $taskChannel = Values::NONE): UpdateTaskOptions
    {
        return new UpdateTaskOptions($attributes, $assignmentStatus, $reason, $priority, $taskChannel);
    }

    public static function read(int $priority = Values::NONE, array $assignmentStatus = Values::ARRAY_NONE, string $workflowSid = Values::NONE, string $workflowName = Values::NONE, string $taskQueueSid = Values::NONE, string $taskQueueName = Values::NONE, string $evaluateTaskAttributes = Values::NONE, string $ordering = Values::NONE, bool $hasAddons = Values::NONE): ReadTaskOptions
    {
        return new ReadTaskOptions($priority, $assignmentStatus, $workflowSid, $workflowName, $taskQueueSid, $taskQueueName, $evaluateTaskAttributes, $ordering, $hasAddons);
    }

    public static function create(int $timeout = Values::NONE, int $priority = Values::NONE, string $taskChannel = Values::NONE, string $workflowSid = Values::NONE, string $attributes = Values::NONE): CreateTaskOptions
    {
        return new CreateTaskOptions($timeout, $priority, $taskChannel, $workflowSid, $attributes);
    }
}

class UpdateTaskOptions extends Options
{
    public function __construct(string $attributes = Values::NONE, string $assignmentStatus = Values::NONE, string $reason = Values::NONE, int $priority = Values::NONE, string $taskChannel = Values::NONE)
    {
        $this->options['attributes'] = $attributes;
        $this->options['assignmentStatus'] = $assignmentStatus;
        $this->options['reason'] = $reason;
        $this->options['priority'] = $priority;
        $this->options['taskChannel'] = $taskChannel;
    }

    public function setAttributes(string $attributes): self
    {
        $this->options['attributes'] = $attributes;
        return $this;
    }

    public function setAssignmentStatus(string $assignmentStatus): self
    {
        $this->options['assignmentStatus'] = $assignmentStatus;
        return $this;
    }

    public function setReason(string $reason): self
    {
        $this->options['reason'] = $reason;
        return $this;
    }

    public function setPriority(int $priority): self
    {
        $this->options['priority'] = $priority;
        return $this;
    }

    public function setTaskChannel(string $taskChannel): self
    {
        $this->options['taskChannel'] = $taskChannel;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.UpdateTaskOptions ' . $options . ']';
    }
}

class ReadTaskOptions extends Options
{
    public function __construct(int $priority = Values::NONE, array $assignmentStatus = Values::ARRAY_NONE, string $workflowSid = Values::NONE, string $workflowName = Values::NONE, string $taskQueueSid = Values::NONE, string $taskQueueName = Values::NONE, string $evaluateTaskAttributes = Values::NONE, string $ordering = Values::NONE, bool $hasAddons = Values::NONE)
    {
        $this->options['priority'] = $priority;
        $this->options['assignmentStatus'] = $assignmentStatus;
        $this->options['workflowSid'] = $workflowSid;
        $this->options['workflowName'] = $workflowName;
        $this->options['taskQueueSid'] = $taskQueueSid;
        $this->options['taskQueueName'] = $taskQueueName;
        $this->options['evaluateTaskAttributes'] = $evaluateTaskAttributes;
        $this->options['ordering'] = $ordering;
        $this->options['hasAddons'] = $hasAddons;
    }

    public function setPriority(int $priority): self
    {
        $this->options['priority'] = $priority;
        return $this;
    }

    public function setAssignmentStatus(array $assignmentStatus): self
    {
        $this->options['assignmentStatus'] = $assignmentStatus;
        return $this;
    }

    public function setWorkflowSid(string $workflowSid): self
    {
        $this->options['workflowSid'] = $workflowSid;
        return $this;
    }

    public function setWorkflowName(string $workflowName): self
    {
        $this->options['workflowName'] = $workflowName;
        return $this;
    }

    public function setTaskQueueSid(string $taskQueueSid): self
    {
        $this->options['taskQueueSid'] = $taskQueueSid;
        return $this;
    }

    public function setTaskQueueName(string $taskQueueName): self
    {
        $this->options['taskQueueName'] = $taskQueueName;
        return $this;
    }

    public function setEvaluateTaskAttributes(string $evaluateTaskAttributes): self
    {
        $this->options['evaluateTaskAttributes'] = $evaluateTaskAttributes;
        return $this;
    }

    public function setOrdering(string $ordering): self
    {
        $this->options['ordering'] = $ordering;
        return $this;
    }

    public function setHasAddons(bool $hasAddons): self
    {
        $this->options['hasAddons'] = $hasAddons;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.ReadTaskOptions ' . $options . ']';
    }
}

class CreateTaskOptions extends Options
{
    public function __construct(int $timeout = Values::NONE, int $priority = Values::NONE, string $taskChannel = Values::NONE, string $workflowSid = Values::NONE, string $attributes = Values::NONE)
    {
        $this->options['timeout'] = $timeout;
        $this->options['priority'] = $priority;
        $this->options['taskChannel'] = $taskChannel;
        $this->options['workflowSid'] = $workflowSid;
        $this->options['attributes'] = $attributes;
    }

    public function setTimeout(int $timeout): self
    {
        $this->options['timeout'] = $timeout;
        return $this;
    }

    public function setPriority(int $priority): self
    {
        $this->options['priority'] = $priority;
        return $this;
    }

    public function setTaskChannel(string $taskChannel): self
    {
        $this->options['taskChannel'] = $taskChannel;
        return $this;
    }

    public function setWorkflowSid(string $workflowSid): self
    {
        $this->options['workflowSid'] = $workflowSid;
        return $this;
    }

    public function setAttributes(string $attributes): self
    {
        $this->options['attributes'] = $attributes;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.CreateTaskOptions ' . $options . ']';
    }
}