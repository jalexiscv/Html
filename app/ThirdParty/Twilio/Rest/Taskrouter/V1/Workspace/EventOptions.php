<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class EventOptions
{
    public static function read(DateTime $endDate = Values::NONE, string $eventType = Values::NONE, int $minutes = Values::NONE, string $reservationSid = Values::NONE, DateTime $startDate = Values::NONE, string $taskQueueSid = Values::NONE, string $taskSid = Values::NONE, string $workerSid = Values::NONE, string $workflowSid = Values::NONE, string $taskChannel = Values::NONE, string $sid = Values::NONE): ReadEventOptions
    {
        return new ReadEventOptions($endDate, $eventType, $minutes, $reservationSid, $startDate, $taskQueueSid, $taskSid, $workerSid, $workflowSid, $taskChannel, $sid);
    }
}

class ReadEventOptions extends Options
{
    public function __construct(DateTime $endDate = Values::NONE, string $eventType = Values::NONE, int $minutes = Values::NONE, string $reservationSid = Values::NONE, DateTime $startDate = Values::NONE, string $taskQueueSid = Values::NONE, string $taskSid = Values::NONE, string $workerSid = Values::NONE, string $workflowSid = Values::NONE, string $taskChannel = Values::NONE, string $sid = Values::NONE)
    {
        $this->options['endDate'] = $endDate;
        $this->options['eventType'] = $eventType;
        $this->options['minutes'] = $minutes;
        $this->options['reservationSid'] = $reservationSid;
        $this->options['startDate'] = $startDate;
        $this->options['taskQueueSid'] = $taskQueueSid;
        $this->options['taskSid'] = $taskSid;
        $this->options['workerSid'] = $workerSid;
        $this->options['workflowSid'] = $workflowSid;
        $this->options['taskChannel'] = $taskChannel;
        $this->options['sid'] = $sid;
    }

    public function setEndDate(DateTime $endDate): self
    {
        $this->options['endDate'] = $endDate;
        return $this;
    }

    public function setEventType(string $eventType): self
    {
        $this->options['eventType'] = $eventType;
        return $this;
    }

    public function setMinutes(int $minutes): self
    {
        $this->options['minutes'] = $minutes;
        return $this;
    }

    public function setReservationSid(string $reservationSid): self
    {
        $this->options['reservationSid'] = $reservationSid;
        return $this;
    }

    public function setStartDate(DateTime $startDate): self
    {
        $this->options['startDate'] = $startDate;
        return $this;
    }

    public function setTaskQueueSid(string $taskQueueSid): self
    {
        $this->options['taskQueueSid'] = $taskQueueSid;
        return $this;
    }

    public function setTaskSid(string $taskSid): self
    {
        $this->options['taskSid'] = $taskSid;
        return $this;
    }

    public function setWorkerSid(string $workerSid): self
    {
        $this->options['workerSid'] = $workerSid;
        return $this;
    }

    public function setWorkflowSid(string $workflowSid): self
    {
        $this->options['workflowSid'] = $workflowSid;
        return $this;
    }

    public function setTaskChannel(string $taskChannel): self
    {
        $this->options['taskChannel'] = $taskChannel;
        return $this;
    }

    public function setSid(string $sid): self
    {
        $this->options['sid'] = $sid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.ReadEventOptions ' . $options . ']';
    }
}