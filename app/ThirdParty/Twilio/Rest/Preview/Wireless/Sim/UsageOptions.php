<?php

namespace Twilio\Rest\Preview\Wireless\Sim;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class UsageOptions
{
    public static function fetch(string $end = Values::NONE, string $start = Values::NONE): FetchUsageOptions
    {
        return new FetchUsageOptions($end, $start);
    }
}

class FetchUsageOptions extends Options
{
    public function __construct(string $end = Values::NONE, string $start = Values::NONE)
    {
        $this->options['end'] = $end;
        $this->options['start'] = $start;
    }

    public function setEnd(string $end): self
    {
        $this->options['end'] = $end;
        return $this;
    }

    public function setStart(string $start): self
    {
        $this->options['start'] = $start;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Wireless.FetchUsageOptions ' . $options . ']';
    }
}