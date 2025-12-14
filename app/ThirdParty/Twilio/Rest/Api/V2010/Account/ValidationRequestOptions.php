<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ValidationRequestOptions
{
    public static function create(string $friendlyName = Values::NONE, int $callDelay = Values::NONE, string $extension = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE): CreateValidationRequestOptions
    {
        return new CreateValidationRequestOptions($friendlyName, $callDelay, $extension, $statusCallback, $statusCallbackMethod);
    }
}

class CreateValidationRequestOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, int $callDelay = Values::NONE, string $extension = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['callDelay'] = $callDelay;
        $this->options['extension'] = $extension;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setCallDelay(int $callDelay): self
    {
        $this->options['callDelay'] = $callDelay;
        return $this;
    }

    public function setExtension(string $extension): self
    {
        $this->options['extension'] = $extension;
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
        return '[Twilio.Api.V2010.CreateValidationRequestOptions ' . $options . ']';
    }
}