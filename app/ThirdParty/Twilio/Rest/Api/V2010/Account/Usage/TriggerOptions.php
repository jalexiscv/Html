<?php

namespace Twilio\Rest\Api\V2010\Account\Usage;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class TriggerOptions
{
    public static function update(string $callbackMethod = Values::NONE, string $callbackUrl = Values::NONE, string $friendlyName = Values::NONE): UpdateTriggerOptions
    {
        return new UpdateTriggerOptions($callbackMethod, $callbackUrl, $friendlyName);
    }

    public static function create(string $callbackMethod = Values::NONE, string $friendlyName = Values::NONE, string $recurring = Values::NONE, string $triggerBy = Values::NONE): CreateTriggerOptions
    {
        return new CreateTriggerOptions($callbackMethod, $friendlyName, $recurring, $triggerBy);
    }

    public static function read(string $recurring = Values::NONE, string $triggerBy = Values::NONE, string $usageCategory = Values::NONE): ReadTriggerOptions
    {
        return new ReadTriggerOptions($recurring, $triggerBy, $usageCategory);
    }
}

class UpdateTriggerOptions extends Options
{
    public function __construct(string $callbackMethod = Values::NONE, string $callbackUrl = Values::NONE, string $friendlyName = Values::NONE)
    {
        $this->options['callbackMethod'] = $callbackMethod;
        $this->options['callbackUrl'] = $callbackUrl;
        $this->options['friendlyName'] = $friendlyName;
    }

    public function setCallbackMethod(string $callbackMethod): self
    {
        $this->options['callbackMethod'] = $callbackMethod;
        return $this;
    }

    public function setCallbackUrl(string $callbackUrl): self
    {
        $this->options['callbackUrl'] = $callbackUrl;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.UpdateTriggerOptions ' . $options . ']';
    }
}

class CreateTriggerOptions extends Options
{
    public function __construct(string $callbackMethod = Values::NONE, string $friendlyName = Values::NONE, string $recurring = Values::NONE, string $triggerBy = Values::NONE)
    {
        $this->options['callbackMethod'] = $callbackMethod;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['recurring'] = $recurring;
        $this->options['triggerBy'] = $triggerBy;
    }

    public function setCallbackMethod(string $callbackMethod): self
    {
        $this->options['callbackMethod'] = $callbackMethod;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setRecurring(string $recurring): self
    {
        $this->options['recurring'] = $recurring;
        return $this;
    }

    public function setTriggerBy(string $triggerBy): self
    {
        $this->options['triggerBy'] = $triggerBy;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.CreateTriggerOptions ' . $options . ']';
    }
}

class ReadTriggerOptions extends Options
{
    public function __construct(string $recurring = Values::NONE, string $triggerBy = Values::NONE, string $usageCategory = Values::NONE)
    {
        $this->options['recurring'] = $recurring;
        $this->options['triggerBy'] = $triggerBy;
        $this->options['usageCategory'] = $usageCategory;
    }

    public function setRecurring(string $recurring): self
    {
        $this->options['recurring'] = $recurring;
        return $this;
    }

    public function setTriggerBy(string $triggerBy): self
    {
        $this->options['triggerBy'] = $triggerBy;
        return $this;
    }

    public function setUsageCategory(string $usageCategory): self
    {
        $this->options['usageCategory'] = $usageCategory;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.ReadTriggerOptions ' . $options . ']';
    }
}