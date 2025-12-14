<?php

namespace Twilio\Rest\Autopilot\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class AssistantOptions
{
    public static function create(string $friendlyName = Values::NONE, bool $logQueries = Values::NONE, string $uniqueName = Values::NONE, string $callbackUrl = Values::NONE, string $callbackEvents = Values::NONE, array $styleSheet = Values::ARRAY_NONE, array $defaults = Values::ARRAY_NONE): CreateAssistantOptions
    {
        return new CreateAssistantOptions($friendlyName, $logQueries, $uniqueName, $callbackUrl, $callbackEvents, $styleSheet, $defaults);
    }

    public static function update(string $friendlyName = Values::NONE, bool $logQueries = Values::NONE, string $uniqueName = Values::NONE, string $callbackUrl = Values::NONE, string $callbackEvents = Values::NONE, array $styleSheet = Values::ARRAY_NONE, array $defaults = Values::ARRAY_NONE, string $developmentStage = Values::NONE): UpdateAssistantOptions
    {
        return new UpdateAssistantOptions($friendlyName, $logQueries, $uniqueName, $callbackUrl, $callbackEvents, $styleSheet, $defaults, $developmentStage);
    }
}

class CreateAssistantOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, bool $logQueries = Values::NONE, string $uniqueName = Values::NONE, string $callbackUrl = Values::NONE, string $callbackEvents = Values::NONE, array $styleSheet = Values::ARRAY_NONE, array $defaults = Values::ARRAY_NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['logQueries'] = $logQueries;
        $this->options['uniqueName'] = $uniqueName;
        $this->options['callbackUrl'] = $callbackUrl;
        $this->options['callbackEvents'] = $callbackEvents;
        $this->options['styleSheet'] = $styleSheet;
        $this->options['defaults'] = $defaults;
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

    public function setStyleSheet(array $styleSheet): self
    {
        $this->options['styleSheet'] = $styleSheet;
        return $this;
    }

    public function setDefaults(array $defaults): self
    {
        $this->options['defaults'] = $defaults;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Autopilot.V1.CreateAssistantOptions ' . $options . ']';
    }
}

class UpdateAssistantOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, bool $logQueries = Values::NONE, string $uniqueName = Values::NONE, string $callbackUrl = Values::NONE, string $callbackEvents = Values::NONE, array $styleSheet = Values::ARRAY_NONE, array $defaults = Values::ARRAY_NONE, string $developmentStage = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['logQueries'] = $logQueries;
        $this->options['uniqueName'] = $uniqueName;
        $this->options['callbackUrl'] = $callbackUrl;
        $this->options['callbackEvents'] = $callbackEvents;
        $this->options['styleSheet'] = $styleSheet;
        $this->options['defaults'] = $defaults;
        $this->options['developmentStage'] = $developmentStage;
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

    public function setStyleSheet(array $styleSheet): self
    {
        $this->options['styleSheet'] = $styleSheet;
        return $this;
    }

    public function setDefaults(array $defaults): self
    {
        $this->options['defaults'] = $defaults;
        return $this;
    }

    public function setDevelopmentStage(string $developmentStage): self
    {
        $this->options['developmentStage'] = $developmentStage;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Autopilot.V1.UpdateAssistantOptions ' . $options . ']';
    }
}