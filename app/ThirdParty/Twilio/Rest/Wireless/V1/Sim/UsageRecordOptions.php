<?php

namespace Twilio\Rest\Wireless\V1\Sim;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class UsageRecordOptions
{
    public static function read(DateTime $end = Values::NONE, DateTime $start = Values::NONE, string $granularity = Values::NONE): ReadUsageRecordOptions
    {
        return new ReadUsageRecordOptions($end, $start, $granularity);
    }
}

class ReadUsageRecordOptions extends Options
{
    public function __construct(DateTime $end = Values::NONE, DateTime $start = Values::NONE, string $granularity = Values::NONE)
    {
        $this->options['end'] = $end;
        $this->options['start'] = $start;
        $this->options['granularity'] = $granularity;
    }

    public function setEnd(DateTime $end): self
    {
        $this->options['end'] = $end;
        return $this;
    }

    public function setStart(DateTime $start): self
    {
        $this->options['start'] = $start;
        return $this;
    }

    public function setGranularity(string $granularity): self
    {
        $this->options['granularity'] = $granularity;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Wireless.V1.ReadUsageRecordOptions ' . $options . ']';
    }
}