<?php

namespace Twilio\Rest\Bulkexports\V1\Export;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class DayOptions
{
    public static function read(string $nextToken = Values::NONE, string $previousToken = Values::NONE): ReadDayOptions
    {
        return new ReadDayOptions($nextToken, $previousToken);
    }
}

class ReadDayOptions extends Options
{
    public function __construct(string $nextToken = Values::NONE, string $previousToken = Values::NONE)
    {
        $this->options['nextToken'] = $nextToken;
        $this->options['previousToken'] = $previousToken;
    }

    public function setNextToken(string $nextToken): self
    {
        $this->options['nextToken'] = $nextToken;
        return $this;
    }

    public function setPreviousToken(string $previousToken): self
    {
        $this->options['previousToken'] = $previousToken;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Bulkexports.V1.ReadDayOptions ' . $options . ']';
    }
}