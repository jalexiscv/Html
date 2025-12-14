<?php

namespace Twilio\Rest\Preview\Understand;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class AssistantOptions
{
    public static function create(string $friendlyName = Values::NONE, bool $logQueries = Values::NONE, string $uniqueName = Values::NONE, string $callbackUrl = Values::NONE, string $callbackEvents = Values::NONE, array $fallbackActions = Values::ARRAY_NONE, array $initiationActions = Values::ARRAY_NONE, array $styleSheet = Values::ARRAY_NONE): CreateAssistantOptions
    {
        return new CreateAssistantOptions($friendlyName, $logQueries, $uniqueName, $callbackUrl, $callbackEvents, $fallbackActions, $initiationActions, $styleSheet);
    }

    public static function update(string $friendlyName = Values::NONE, bool $logQueries = Values::NONE, string $uniqueName = Values::NONE, string $callbackUrl = Values::NONE, string $callbackEvents = Values::NONE, array $fallbackActions = Values::ARRAY_NONE, array $initiationActions = Values::ARRAY_NONE, array $styleSheet = Values::ARRAY_NONE): UpdateAssistantOptions
    {
        return new UpdateAssistantOptions($friendlyName, $logQueries, $uniqueName, $callbackUrl, $callbackEvents, $fallbackActions, $initiationActions, $styleSheet);
    }
}

class CreateAssistantOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, bool $logQueries = Values::NONE, string $uniqueName = Values::NONE, string $callbackUrl = Values::NONE, string $callbackEvents = Values::NONE, array $fallbackActions = Values::ARRAY_NONE, array $initiationActions = Values::ARRAY_NONE, array $styleSheet = Values::ARRAY_NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['logQueries'] = $logQueries;
        $this->options['uniqueName'] = $uniqueName;
        $this->options['callbackUrl'] = $callbackUrl;
        $this->options['callbackEvents'] = $callbackEvents;
        $this->options['fallbackActions'] = $fallbackActions;
        $this->options['initiationActions'] = $initiationActions;
        $this->options['styleSheet'] = $styleSheet;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setLogQueries(bool $logQueries): self
    {
        $this->options['logQueries'] = $logQueries;
        return $this;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setCallbackUrl(string $callbackUrl): self
    {
        $this->options['callbackUrl'] = $callbackUrl;
        return $this;
    }

    public function setCallbackEvents(string $callbackEvents): self
    {
        $this->options['callbackEvents'] = $callbackEvents;
        return $this;
    }

    public function setFallbackActions(array $fallbackActions): self
    {
        $this->options['fallbackActions'] = $fallbackActions;
        return $this;
    }

    public function setInitiationActions(array $initiationActions): self
    {
        $this->options['initiationActions'] = $initiationActions;
        return $this;
    }

    public function setStyleSheet(array $styleSheet): self
    {
        $this->options['styleSheet'] = $styleSheet;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Understand.CreateAssistantOptions ' . $options . ']';
    }
}

class UpdateAssistantOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, bool $logQueries = Values::NONE, string $uniqueName = Values::NONE, string $callbackUrl = Values::NONE, string $callbackEvents = Values::NONE, array $fallbackActions = Values::ARRAY_NONE, array $initiationActions = Values::ARRAY_NONE, array $styleSheet = Values::ARRAY_NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['logQueries'] = $logQueries;
        $this->options['uniqueName'] = $uniqueName;
        $this->options['callbackUrl'] = $callbackUrl;
        $this->options['callbackEvents'] = $callbackEvents;
        $this->options['fallbackActions'] = $fallbackActions;
        $this->options['initiationActions'] = $initiationActions;
        $this->options['styleSheet'] = $styleSheet;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setLogQueries(bool $logQueries): self
    {
        $this->options['logQueries'] = $logQueries;
        return $this;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setCallbackUrl(string $callbackUrl): self
    {
        $this->options['callbackUrl'] = $callbackUrl;
        return $this;
    }

    public function setCallbackEvents(string $callbackEvents): self
    {
        $this->options['callbackEvents'] = $callbackEvents;
        return $this;
    }

    public function setFallbackActions(array $fallbackActions): self
    {
        $this->options['fallbackActions'] = $fallbackActions;
        return $this;
    }

    public function setInitiationActions(array $initiationActions): self
    {
        $this->options['initiationActions'] = $initiationActions;
        return $this;
    }

    public function setStyleSheet(array $styleSheet): self
    {
        $this->options['styleSheet'] = $styleSheet;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Understand.UpdateAssistantOptions ' . $options . ']';
    }
}