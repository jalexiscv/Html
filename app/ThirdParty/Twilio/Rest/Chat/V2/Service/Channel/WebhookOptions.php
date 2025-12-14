<?php

namespace Twilio\Rest\Chat\V2\Service\Channel;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class WebhookOptions
{
    public static function create(string $configurationUrl = Values::NONE, string $configurationMethod = Values::NONE, array $configurationFilters = Values::ARRAY_NONE, array $configurationTriggers = Values::ARRAY_NONE, string $configurationFlowSid = Values::NONE, int $configurationRetryCount = Values::NONE): CreateWebhookOptions
    {
        return new CreateWebhookOptions($configurationUrl, $configurationMethod, $configurationFilters, $configurationTriggers, $configurationFlowSid, $configurationRetryCount);
    }

    public static function update(string $configurationUrl = Values::NONE, string $configurationMethod = Values::NONE, array $configurationFilters = Values::ARRAY_NONE, array $configurationTriggers = Values::ARRAY_NONE, string $configurationFlowSid = Values::NONE, int $configurationRetryCount = Values::NONE): UpdateWebhookOptions
    {
        return new UpdateWebhookOptions($configurationUrl, $configurationMethod, $configurationFilters, $configurationTriggers, $configurationFlowSid, $configurationRetryCount);
    }
}

class CreateWebhookOptions extends Options
{
    public function __construct(string $configurationUrl = Values::NONE, string $configurationMethod = Values::NONE, array $configurationFilters = Values::ARRAY_NONE, array $configurationTriggers = Values::ARRAY_NONE, string $configurationFlowSid = Values::NONE, int $configurationRetryCount = Values::NONE)
    {
        $this->options['configurationUrl'] = $configurationUrl;
        $this->options['configurationMethod'] = $configurationMethod;
        $this->options['configurationFilters'] = $configurationFilters;
        $this->options['configurationTriggers'] = $configurationTriggers;
        $this->options['configurationFlowSid'] = $configurationFlowSid;
        $this->options['configurationRetryCount'] = $configurationRetryCount;
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

    public function setConfigurationRetryCount(int $configurationRetryCount): self
    {
        $this->options['configurationRetryCount'] = $configurationRetryCount;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Chat.V2.CreateWebhookOptions ' . $options . ']';
    }
}

class UpdateWebhookOptions extends Options
{
    public function __construct(string $configurationUrl = Values::NONE, string $configurationMethod = Values::NONE, array $configurationFilters = Values::ARRAY_NONE, array $configurationTriggers = Values::ARRAY_NONE, string $configurationFlowSid = Values::NONE, int $configurationRetryCount = Values::NONE)
    {
        $this->options['configurationUrl'] = $configurationUrl;
        $this->options['configurationMethod'] = $configurationMethod;
        $this->options['configurationFilters'] = $configurationFilters;
        $this->options['configurationTriggers'] = $configurationTriggers;
        $this->options['configurationFlowSid'] = $configurationFlowSid;
        $this->options['configurationRetryCount'] = $configurationRetryCount;
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

    public function setConfigurationRetryCount(int $configurationRetryCount): self
    {
        $this->options['configurationRetryCount'] = $configurationRetryCount;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Chat.V2.UpdateWebhookOptions ' . $options . ']';
    }
}