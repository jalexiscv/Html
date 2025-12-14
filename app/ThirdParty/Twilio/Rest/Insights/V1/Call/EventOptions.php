<?php

namespace Twilio\Rest\Insights\V1\Call;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class EventOptions
{
    public static function read(string $edge = Values::NONE): ReadEventOptions
    {
        return new ReadEventOptions($edge);
    }
}

class ReadEventOptions extends Options
{
    public function __construct(string $edge = Values::NONE)
    {
        $this->options['edge'] = $edge;
    }

    public function setEdge(string $edge): self
    {
        $this->options['edge'] = $edge;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Insights.V1.ReadEventOptions ' . $options . ']';
    }
}