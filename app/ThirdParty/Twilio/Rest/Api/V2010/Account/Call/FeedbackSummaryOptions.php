<?php

namespace Twilio\Rest\Api\V2010\Account\Call;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class FeedbackSummaryOptions
{
    public static function create(bool $includeSubaccounts = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE): CreateFeedbackSummaryOptions
    {
        return new CreateFeedbackSummaryOptions($includeSubaccounts, $statusCallback, $statusCallbackMethod);
    }
}

class CreateFeedbackSummaryOptions extends Options
{
    public function __construct(bool $includeSubaccounts = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE)
    {
        $this->options['includeSubaccounts'] = $includeSubaccounts;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
    }

    public function setIncludeSubaccounts(bool $includeSubaccounts): self
    {
        $this->options['includeSubaccounts'] = $includeSubaccounts;
        return $this;
    }

    public function setStatusCallback(string $statusCallback): self
    {
        $this->options['statusCallback'] = $statusCallback;
        return $this;
    }

    public function setStatusCallbackMethod(string $statusCallbackMethod): self
    {
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.CreateFeedbackSummaryOptions ' . $options . ']';
    }
}