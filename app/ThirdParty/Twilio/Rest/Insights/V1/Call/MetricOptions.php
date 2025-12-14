<?php

namespace Twilio\Rest\Insights\V1\Call;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class MetricOptions
{
    public static function read(string $edge = Values::NONE, string $direction = Values::NONE): ReadMetricOptions
    {
        return new ReadMetricOptions($edge, $direction);
    }
}

class ReadMetricOptions extends Options
{
    public function __construct(string $edge = Values::NONE, string $direction = Values::NONE)
    {
        $this->options['edge'] = $edge;
        $this->options['direction'] = $direction;
    }

    public function setEdge(string $edge): self
    {
        $this->options['edge'] = $edge;
        return $this;
    }

    public function setDirection(string $direction): self
    {
        $this->options['direction'] = $direction;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Insights.V1.ReadMetricOptions ' . $options . ']';
    }
}