<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class WorkerOptions
{
    public static function read(string $activityName = Values::NONE, string $activitySid = Values::NONE, string $available = Values::NONE, string $friendlyName = Values::NONE, string $targetWorkersExpression = Values::NONE, string $taskQueueName = Values::NONE, string $taskQueueSid = Values::NONE): ReadWorkerOptions
    {
        return new ReadWorkerOptions($activityName, $activitySid, $available, $friendlyName, $targetWorkersExpression, $taskQueueName, $taskQueueSid);
    }

    public static function create(string $activitySid = Values::NONE, string $attributes = Values::NONE): CreateWorkerOptions
    {
        return new CreateWorkerOptions($activitySid, $attributes);
    }

    public static function update(string $activitySid = Values::NONE, string $attributes = Values::NONE, string $friendlyName = Values::NONE, bool $rejectPendingReservations = Values::NONE): UpdateWorkerOptions
    {
        return new UpdateWorkerOptions($activitySid, $attributes, $friendlyName, $rejectPendingReservations);
    }
}

class ReadWorkerOptions extends Options
{
    public function __construct(string $activityName = Values::NONE, string $activitySid = Values::NONE, string $available = Values::NONE, string $friendlyName = Values::NONE, string $targetWorkersExpression = Values::NONE, string $taskQueueName = Values::NONE, string $taskQueueSid = Values::NONE)
    {
        $this->options['activityName'] = $activityName;
        $this->options['activitySid'] = $activitySid;
        $this->options['available'] = $available;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['targetWorkersExpression'] = $targetWorkersExpression;
        $this->options['taskQueueName'] = $taskQueueName;
        $this->options['taskQueueSid'] = $taskQueueSid;
    }

    public function setActivityName(string $activityName): self
    {
        $this->options['activityName'] = $activityName;
        return $this;
    }

    public function setActivitySid(string $activitySid): self
    {
        $this->options['activitySid'] = $activitySid;
        return $this;
    }

    public function setAvailable(string $available): self
    {
        $this->options['available'] = $available;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setTargetWorkersExpression(string $targetWorkersExpression): self
    {
        $this->options['targetWorkersExpression'] = $targetWorkersExpression;
        return $this;
    }

    public function setTaskQueueName(string $taskQueueName): self
    {
        $this->options['taskQueueName'] = $taskQueueName;
        return $this;
    }

    public function setTaskQueueSid(string $taskQueueSid): self
    {
        $this->options['taskQueueSid'] = $taskQueueSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.ReadWorkerOptions ' . $options . ']';
    }
}

class CreateWorkerOptions extends Options
{
    public function __construct(string $activitySid = Values::NONE, string $attributes = Values::NONE)
    {
        $this->options['activitySid'] = $activitySid;
        $this->options['attributes'] = $attributes;
    }

    public function setActivitySid(string $activitySid): self
    {
        $this->options['activitySid'] = $activitySid;
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
        return '[Twilio.Taskrouter.V1.CreateWorkerOptions ' . $options . ']';
    }
}

class UpdateWorkerOptions extends Options
{
    public function __construct(string $activitySid = Values::NONE, string $attributes = Values::NONE, string $friendlyName = Values::NONE, bool $rejectPendingReservations = Values::NONE)
    {
        $this->options['activitySid'] = $activitySid;
        $this->options['attributes'] = $attributes;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['rejectPendingReservations'] = $rejectPendingReservations;
    }

    public function setActivitySid(string $activitySid): self
    {
        $this->options['activitySid'] = $activitySid;
        return $this;
    }

    public function setAttributes(string $attributes): self
    {
        $this->options['attributes'] = $attributes;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setRejectPendingReservations(bool $rejectPendingReservations): self
    {
        $this->options['rejectPendingReservations'] = $rejectPendingReservations;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.UpdateWorkerOptions ' . $options . ']';
    }
}