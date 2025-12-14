<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class TaskQueueStatisticsOptions
{
    public static function fetch(DateTime $endDate = Values::NONE, int $minutes = Values::NONE, DateTime $startDate = Values::NONE, string $taskChannel = Values::NONE, string $splitByWaitTime = Values::NONE): FetchTaskQueueStatisticsOptions
    {
        return new FetchTaskQueueStatisticsOptions($endDate, $minutes, $startDate, $taskChannel, $splitByWaitTime);
    }
}

class FetchTaskQueueStatisticsOptions extends Options
{
    public function __construct(DateTime $endDate = Values::NONE, int $minutes = Values::NONE, DateTime $startDate = Values::NONE, string $taskChannel = Values::NONE, string $splitByWaitTime = Values::NONE)
    {
        $this->options['endDate'] = $endDate;
        $this->options['minutes'] = $minutes;
        $this->options['startDate'] = $startDate;
        $this->options['taskChannel'] = $taskChannel;
        $this->options['splitByWaitTime'] = $splitByWaitTime;
    }

    public function setEndDate(DateTime $endDate): self
    {
        $this->options['endDate'] = $endDate;
        return $this;
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

    public function setTaskChannel(string $taskChannel): self
    {
        $this->options['taskChannel'] = $taskChannel;
        return $this;
    }

    public function setSplitByWaitTime(string $splitByWaitTime): self
    {
        $this->options['splitByWaitTime'] = $splitByWaitTime;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.FetchTaskQueueStatisticsOptions ' . $options . ']';
    }
}