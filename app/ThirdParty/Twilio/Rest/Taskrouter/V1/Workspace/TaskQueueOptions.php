<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class TaskQueueOptions
{
    public static function update(string $friendlyName = Values::NONE, string $targetWorkers = Values::NONE, string $reservationActivitySid = Values::NONE, string $assignmentActivitySid = Values::NONE, int $maxReservedWorkers = Values::NONE, string $taskOrder = Values::NONE): UpdateTaskQueueOptions
    {
        return new UpdateTaskQueueOptions($friendlyName, $targetWorkers, $reservationActivitySid, $assignmentActivitySid, $maxReservedWorkers, $taskOrder);
    }

    public static function read(string $friendlyName = Values::NONE, string $evaluateWorkerAttributes = Values::NONE, string $workerSid = Values::NONE): ReadTaskQueueOptions
    {
        return new ReadTaskQueueOptions($friendlyName, $evaluateWorkerAttributes, $workerSid);
    }

    public static function create(string $targetWorkers = Values::NONE, int $maxReservedWorkers = Values::NONE, string $taskOrder = Values::NONE, string $reservationActivitySid = Values::NONE, string $assignmentActivitySid = Values::NONE): CreateTaskQueueOptions
    {
        return new CreateTaskQueueOptions($targetWorkers, $maxReservedWorkers, $taskOrder, $reservationActivitySid, $assignmentActivitySid);
    }
}

class UpdateTaskQueueOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $targetWorkers = Values::NONE, string $reservationActivitySid = Values::NONE, string $assignmentActivitySid = Values::NONE, int $maxReservedWorkers = Values::NONE, string $taskOrder = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['targetWorkers'] = $targetWorkers;
        $this->options['reservationActivitySid'] = $reservationActivitySid;
        $this->options['assignmentActivitySid'] = $assignmentActivitySid;
        $this->options['maxReservedWorkers'] = $maxReservedWorkers;
        $this->options['taskOrder'] = $taskOrder;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setTargetWorkers(string $targetWorkers): self
    {
        $this->options['targetWorkers'] = $targetWorkers;
        return $this;
    }

    public function setReservationActivitySid(string $reservationActivitySid): self
    {
        $this->options['reservationActivitySid'] = $reservationActivitySid;
        return $this;
    }

    public function setAssignmentActivitySid(string $assignmentActivitySid): self
    {
        $this->options['assignmentActivitySid'] = $assignmentActivitySid;
        return $this;
    }

    public function setMaxReservedWorkers(int $maxReservedWorkers): self
    {
        $this->options['maxReservedWorkers'] = $maxReservedWorkers;
        return $this;
    }

    public function setTaskOrder(string $taskOrder): self
    {
        $this->options['taskOrder'] = $taskOrder;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.UpdateTaskQueueOptions ' . $options . ']';
    }
}

class ReadTaskQueueOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $evaluateWorkerAttributes = Values::NONE, string $workerSid = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['evaluateWorkerAttributes'] = $evaluateWorkerAttributes;
        $this->options['workerSid'] = $workerSid;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setEvaluateWorkerAttributes(string $evaluateWorkerAttributes): self
    {
        $this->options['evaluateWorkerAttributes'] = $evaluateWorkerAttributes;
        return $this;
    }

    public function setWorkerSid(string $workerSid): self
    {
        $this->options['workerSid'] = $workerSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.ReadTaskQueueOptions ' . $options . ']';
    }
}

class CreateTaskQueueOptions extends Options
{
    public function __construct(string $targetWorkers = Values::NONE, int $maxReservedWorkers = Values::NONE, string $taskOrder = Values::NONE, string $reservationActivitySid = Values::NONE, string $assignmentActivitySid = Values::NONE)
    {
        $this->options['targetWorkers'] = $targetWorkers;
        $this->options['maxReservedWorkers'] = $maxReservedWorkers;
        $this->options['taskOrder'] = $taskOrder;
        $this->options['reservationActivitySid'] = $reservationActivitySid;
        $this->options['assignmentActivitySid'] = $assignmentActivitySid;
    }

    public function setTargetWorkers(string $targetWorkers): self
    {
        $this->options['targetWorkers'] = $targetWorkers;
        return $this;
    }

    public function setMaxReservedWorkers(int $maxReservedWorkers): self
    {
        $this->options['maxReservedWorkers'] = $maxReservedWorkers;
        return $this;
    }

    public function setTaskOrder(string $taskOrder): self
    {
        $this->options['taskOrder'] = $taskOrder;
        return $this;
    }

    public function setReservationActivitySid(string $reservationActivitySid): self
    {
        $this->options['reservationActivitySid'] = $reservationActivitySid;
        return $this;
    }

    public function setAssignmentActivitySid(string $assignmentActivitySid): self
    {
        $this->options['assignmentActivitySid'] = $assignmentActivitySid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.CreateTaskQueueOptions ' . $options . ']';
    }
}