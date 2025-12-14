<?php

namespace Twilio\Rest\Conversations\V1\Service\Conversation;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class WebhookOptions
{
    public static function create(string $configurationUrl = Values::NONE, string $configurationMethod = Values::NONE, array $configurationFilters = Values::ARRAY_NONE, array $configurationTriggers = Values::ARRAY_NONE, string $configurationFlowSid = Values::NONE, int $configurationReplayAfter = Values::NONE): CreateWebhookOptions
    {
        return new CreateWebhookOptions($configurationUrl, $configurationMethod, $configurationFilters, $configurationTriggers, $configurationFlowSid, $configurationReplayAfter);
    }

    public static function update(string $configurationUrl = Values::NONE, string $configurationMethod = Values::NONE, array $configurationFilters = Values::ARRAY_NONE, array $configurationTriggers = Values::ARRAY_NONE, string $configurationFlowSid = Values::NONE): UpdateWebhookOptions
    {
        return new UpdateWebhookOptions($configurationUrl, $configurationMethod, $configurationFilters, $configurationTriggers, $configurationFlowSid);
    }
}

class CreateWebhookOptions extends Options
{
    public function __construct(string $configurationUrl = Values::NONE, string $configurationMethod = Values::NONE, array $configurationFilters = Values::ARRAY_NONE, array $configurationTriggers = Values::ARRAY_NONE, string $configurationFlowSid = Values::NONE, int $configurationReplayAfter = Values::NONE)
    {
        $this->options['configurationUrl'] = $configurationUrl;
        $this->options['configurationMethod'] = $configurationMethod;
        $this->options['configurationFilters'] = $configurationFilters;
        $this->options['configurationTriggers'] = $configurationTriggers;
        $this->options['configurationFlowSid'] = $configurationFlowSid;
        $this->options['configurationReplayAfter'] = $configurationReplayAfter;
    }

    public function setConfigurationUrl(string $configurationUrl): self
    {
        $this->options['configurationUrl'] = $configurationUrl;
        return $this;
    }

    public function setConfigurationMethod(string $configurationMethod): self
    {
        $this->options['configurationMethod'] = $configurationMethod;
        return $this;
    }

    public function setConfigurationFilters(array $configurationFilters): self
    {
        $this->options['configurationFilters'] = $configurationFilters;
        return $this;
    }

    public function setConfigurationTriggers(array $configurationTriggers): self
    {
        $this->options['configurationTriggers'] = $configurationTriggers;
        return $this;
    }

    public function setConfigurationFlowSid(string $configurationFlowSid): self
    {
        $this->options['configurationFlowSid'] = $configurationFlowSid;
        return $this;
    }

    public function setConfigurationReplayAfter(int $configurationReplayAfter): self
    {
        $this->options['configurationReplayAfter'] = $configurationReplayAfter;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Conversations.V1.CreateWebhookOptions ' . $options . ']';
    }
}

class UpdateWebhookOptions extends Options
{
    public function __construct(string $configurationUrl = Values::NONE, string $configurationMethod = Values::NONE, array $configurationFilters = Values::ARRAY_NONE, array $configurationTriggers = Values::ARRAY_NONE, string $configurationFlowSid = Values::NONE)
    {
        $this->options['configurationUrl'] = $configurationUrl;
        $this->options['configurationMethod'] = $configurationMethod;
        $this->options['configurationFilters'] = $configurationFilters;
        $this->options['configurationTriggers'] = $configurationTriggers;
        $this->options['configurationFlowSid'] = $configurationFlowSid;
    }

    public function setConfigurationUrl(string $configurationUrl): self
    {
        $this->options['configurationUrl'] = $configurationUrl;
        return $this;
    }

    public function setConfigurationMethod(string $configurationMethod): self
    {
        $this->options['configurationMethod'] = $configurationMethod;
        return $this;
    }

    public function setConfigurationFilters(array $configurationFilters): self
    {
        $this->options['configurationFilters'] = $configurationFilters;
        return $this;
    }

    public function setConfigurationTriggers(array $configurationTriggers): self
    {
        $this->options['configurationTriggers'] = $configurationTriggers;
        return $this;
    }

    public function setConfigurationFlowSid(string $configurationFlowSid): self
    {
        $this->options['configurationFlowSid'] = $configurationFlowSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Conversations.V1.UpdateWebhookOptions ' . $options . ']';
    }
}