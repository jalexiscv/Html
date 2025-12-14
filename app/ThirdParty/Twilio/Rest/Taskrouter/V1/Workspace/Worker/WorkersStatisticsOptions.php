<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class WorkersStatisticsOptions
{
    public static function fetch(int $minutes = Values::NONE, DateTime $startDate = Values::NONE, DateTime $endDate = Values::NONE, string $taskQueueSid = Values::NONE, string $taskQueueName = Values::NONE, string $friendlyName = Values::NONE, string $taskChannel = Values::NONE): FetchWorkersStatisticsOptions
    {
        return new FetchWorkersStatisticsOptions($minutes, $startDate, $endDate, $taskQueueSid, $taskQueueName, $friendlyName, $taskChannel);
    }
}

class FetchWorkersStatisticsOptions extends Options
{
    public function __construct(int $minutes = Values::NONE, DateTime $startDate = Values::NONE, DateTime $endDate = Values::NONE, string $taskQueueSid = Values::NONE, string $taskQueueName = Values::NONE, string $friendlyName = Values::NONE, string $taskChannel = Values::NONE)
    {
        $this->options['minutes'] = $minutes;
        $this->options['startDate'] = $startDate;
        $this->options['endDate'] = $endDate;
        $this->options['taskQueueSid'] = $taskQueueSid;
        $this->options['taskQueueName'] = $taskQueueName;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['taskChannel'] = $taskChannel;
    }

    public function setMinutes(int $minutes): self
    {
        $this->options['minutes'] = $minutes;
        return $this;
    }

    public function setStartDate(DateTime $startDate): self
    {
        $this->options['startDate'] = $startDate;
        return $this;
    }

    public function setEndDate(DateTime $endDate): self
    {
        $this->options['endDate'] = $endDate;
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

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
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
        return '[Twilio.Taskrouter.V1.FetchWorkersStatisticsOptions ' . $options . ']';
    }
}