<?php

namespace Twilio\Rest\Autopilot\V1\Assistant;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class WebhookOptions
{
    public static function create(string $webhookMethod = Values::NONE): CreateWebhookOptions
    {
        return new CreateWebhookOptions($webhookMethod);
    }

    public static function update(string $uniqueName = Values::NONE, string $events = Values::NONE, string $webhookUrl = Values::NONE, string $webhookMethod = Values::NONE): UpdateWebhookOptions
    {
        return new UpdateWebhookOptions($uniqueName, $events, $webhookUrl, $webhookMethod);
    }
}

class CreateWebhookOptions extends Options
{
    public function __construct(string $webhookMethod = Values::NONE)
    {
        $this->options['webhookMethod'] = $webhookMethod;
    }

    public function setWebhookMethod(string $webhookMethod): self
    {
        $this->options['webhookMethod'] = $webhookMethod;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Autopilot.V1.CreateWebhookOptions ' . $options . ']';
    }
}

class UpdateWebhookOptions extends Options
{
    public function __construct(string $uniqueName = Values::NONE, string $events = Values::NONE, string $webhookUrl = Values::NONE, string $webhookMethod = Values::NONE)
    {
        $this->options['uniqueName'] = $uniqueName;
        $this->options['events'] = $events;
        $this->options['webhookUrl'] = $webhookUrl;
        $this->options['webhookMethod'] = $webhookMethod;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setEvents(string $events): self
    {
        $this->options['events'] = $events;
        return $this;
    }

    public function setWebhookUrl(string $webhookUrl): self
    {
        $this->options['webhookUrl'] = $webhookUrl;
        return $this;
    }

    public function setWebhookMethod(string $webhookMethod): self
    {
        $this->options['webhookMethod'] = $webhookMethod;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Autopilot.V1.UpdateWebhookOptions ' . $options . ']';
    }
}