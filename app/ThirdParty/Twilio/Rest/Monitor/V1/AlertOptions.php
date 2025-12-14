<?php

namespace Twilio\Rest\Monitor\V1;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class AlertOptions
{
    public static function read(string $logLevel = Values::NONE, DateTime $startDate = Values::NONE, DateTime $endDate = Values::NONE): ReadAlertOptions
    {
        return new ReadAlertOptions($logLevel, $startDate, $endDate);
    }
}

class ReadAlertOptions extends Options
{
    public function __construct(string $logLevel = Values::NONE, DateTime $startDate = Values::NONE, DateTime $endDate = Values::NONE)
    {
        $this->options['logLevel'] = $logLevel;
        $this->options['startDate'] = $startDate;
        $this->options['endDate'] = $endDate;
    }

    public function setLogLevel(string $logLevel): self
    {
        $this->options['logLevel'] = $logLevel;
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

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Monitor.V1.ReadAlertOptions ' . $options . ']';
    }
}