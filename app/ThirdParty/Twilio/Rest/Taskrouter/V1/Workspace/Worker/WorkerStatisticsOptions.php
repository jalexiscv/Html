<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class WorkerStatisticsOptions
{
    public static function fetch(int $minutes = Values::NONE, DateTime $startDate = Values::NONE, DateTime $endDate = Values::NONE, string $taskChannel = Values::NONE): FetchWorkerStatisticsOptions
    {
        return new FetchWorkerStatisticsOptions($minutes, $startDate, $endDate, $taskChannel);
    }
}

class FetchWorkerStatisticsOptions extends Options
{
    public function __construct(int $minutes = Values::NONE, DateTime $startDate = Values::NONE, DateTime $endDate = Values::NONE, string $taskChannel = Values::NONE)
    {
        $this->options['minutes'] = $minutes;
        $this->options['startDate'] = $startDate;
        $this->options['endDate'] = $endDate;
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

    public function setTaskChannel(string $taskChannel): self
    {
        $this->options['taskChannel'] = $taskChannel;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.FetchWorkerStatisticsOptions ' . $options . ']';
    }
}