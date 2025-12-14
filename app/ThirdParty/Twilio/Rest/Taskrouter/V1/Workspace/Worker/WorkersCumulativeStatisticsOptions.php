<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class WorkersCumulativeStatisticsOptions
{
    public static function fetch(DateTime $endDate = Values::NONE, int $minutes = Values::NONE, DateTime $startDate = Values::NONE, string $taskChannel = Values::NONE): FetchWorkersCumulativeStatisticsOptions
    {
        return new FetchWorkersCumulativeStatisticsOptions($endDate, $minutes, $startDate, $taskChannel);
    }
}

class FetchWorkersCumulativeStatisticsOptions extends Options
{
    public function __construct(DateTime $endDate = Values::NONE, int $minutes = Values::NONE, DateTime $startDate = Values::NONE, string $taskChannel = Values::NONE)
    {
        $this->options['endDate'] = $endDate;
        $this->options['minutes'] = $minutes;
        $this->options['startDate'] = $startDate;
        $this->options['taskChannel'] = $taskChannel;
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

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.FetchWorkersCumulativeStatisticsOptions ' . $options . ']';
    }
}