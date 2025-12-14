<?php

namespace Twilio\Rest\Serverless\V1\Service\Environment;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class LogOptions
{
    public static function read(string $functionSid = Values::NONE, DateTime $startDate = Values::NONE, DateTime $endDate = Values::NONE): ReadLogOptions
    {
        return new ReadLogOptions($functionSid, $startDate, $endDate);
    }
}

class ReadLogOptions extends Options
{
    public function __construct(string $functionSid = Values::NONE, DateTime $startDate = Values::NONE, DateTime $endDate = Values::NONE)
    {
        $this->options['functionSid'] = $functionSid;
        $this->options['startDate'] = $startDate;
        $this->options['endDate'] = $endDate;
    }

    public function setFunctionSid(string $functionSid): self
    {
        $this->options['functionSid'] = $functionSid;
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
        return '[Twilio.Serverless.V1.ReadLogOptions ' . $options . ']';
    }
}