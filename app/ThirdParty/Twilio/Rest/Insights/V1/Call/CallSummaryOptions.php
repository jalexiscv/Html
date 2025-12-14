<?php

namespace Twilio\Rest\Insights\V1\Call;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class CallSummaryOptions
{
    public static function fetch(string $processingState = Values::NONE): FetchCallSummaryOptions
    {
        return new FetchCallSummaryOptions($processingState);
    }
}

class FetchCallSummaryOptions extends Options
{
    public function __construct(string $processingState = Values::NONE)
    {
        $this->options['processingState'] = $processingState;
    }

    public function setProcessingState(string $processingState): self
    {
        $this->options['processingState'] = $processingState;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Insights.V1.FetchCallSummaryOptions ' . $options . ']';
    }
}