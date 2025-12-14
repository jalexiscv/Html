<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class WorkflowOptions
{
    public static function update(string $friendlyName = Values::NONE, string $assignmentCallbackUrl = Values::NONE, string $fallbackAssignmentCallbackUrl = Values::NONE, string $configuration = Values::NONE, int $taskReservationTimeout = Values::NONE, string $reEvaluateTasks = Values::NONE): UpdateWorkflowOptions
    {
        return new UpdateWorkflowOptions($friendlyName, $assignmentCallbackUrl, $fallbackAssignmentCallbackUrl, $configuration, $taskReservationTimeout, $reEvaluateTasks);
    }

    public static function read(string $friendlyName = Values::NONE): ReadWorkflowOptions
    {
        return new ReadWorkflowOptions($friendlyName);
    }

    public static function create(string $assignmentCallbackUrl = Values::NONE, string $fallbackAssignmentCallbackUrl = Values::NONE, int $taskReservationTimeout = Values::NONE): CreateWorkflowOptions
    {
        return new CreateWorkflowOptions($assignmentCallbackUrl, $fallbackAssignmentCallbackUrl, $taskReservationTimeout);
    }
}

class UpdateWorkflowOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $assignmentCallbackUrl = Values::NONE, string $fallbackAssignmentCallbackUrl = Values::NONE, string $configuration = Values::NONE, int $taskReservationTimeout = Values::NONE, string $reEvaluateTasks = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['assignmentCallbackUrl'] = $assignmentCallbackUrl;
        $this->options['fallbackAssignmentCallbackUrl'] = $fallbackAssignmentCallbackUrl;
        $this->options['configuration'] = $configuration;
        $this->options['taskReservationTimeout'] = $taskReservationTimeout;
        $this->options['reEvaluateTasks'] = $reEvaluateTasks;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setAssignmentCallbackUrl(string $assignmentCallbackUrl): self
    {
        $this->options['assignmentCallbackUrl'] = $assignmentCallbackUrl;
        return $this;
    }

    public function setFallbackAssignmentCallbackUrl(string $fallbackAssignmentCallbackUrl): self
    {
        $this->options['fallbackAssignmentCallbackUrl'] = $fallbackAssignmentCallbackUrl;
        return $this;
    }

    public function setConfiguration(string $configuration): self
    {
        $this->options['configuration'] = $configuration;
        return $this;
    }

    public function setTaskReservationTimeout(int $taskReservationTimeout): self
    {
        $this->options['taskReservationTimeout'] = $taskReservationTimeout;
        return $this;
    }

    public function setReEvaluateTasks(string $reEvaluateTasks): self
    {
        $this->options['reEvaluateTasks'] = $reEvaluateTasks;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.UpdateWorkflowOptions ' . $options . ']';
    }
}

class ReadWorkflowOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.ReadWorkflowOptions ' . $options . ']';
    }
}

class CreateWorkflowOptions extends Options
{
    public function __construct(string $assignmentCallbackUrl = Values::NONE, string $fallbackAssignmentCallbackUrl = Values::NONE, int $taskReservationTimeout = Values::NONE)
    {
        $this->options['assignmentCallbackUrl'] = $assignmentCallbackUrl;
        $this->options['fallbackAssignmentCallbackUrl'] = $fallbackAssignmentCallbackUrl;
        $this->options['taskReservationTimeout'] = $taskReservationTimeout;
    }

    public function setAssignmentCallbackUrl(string $assignmentCallbackUrl): self
    {
        $this->options['assignmentCallbackUrl'] = $assignmentCallbackUrl;
        return $this;
    }

    public function setFallbackAssignmentCallbackUrl(string $fallbackAssignmentCallbackUrl): self
    {
        $this->options['fallbackAssignmentCallbackUrl'] = $fallbackAssignmentCallbackUrl;
        return $this;
    }

    public function setTaskReservationTimeout(int $taskReservationTimeout): self
    {
        $this->options['taskReservationTimeout'] = $taskReservationTimeout;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.CreateWorkflowOptions ' . $options . ']';
    }
}