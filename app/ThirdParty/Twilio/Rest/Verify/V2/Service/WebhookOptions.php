<?php

namespace Twilio\Rest\Verify\V2\Service;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class WebhookOptions
{
    public static function create(string $status = Values::NONE): CreateWebhookOptions
    {
        return new CreateWebhookOptions($status);
    }

    public static function update(string $friendlyName = Values::NONE, array $eventTypes = Values::ARRAY_NONE, string $webhookUrl = Values::NONE, string $status = Values::NONE): UpdateWebhookOptions
    {
        return new UpdateWebhookOptions($friendlyName, $eventTypes, $webhookUrl, $status);
    }
}

class CreateWebhookOptions extends Options
{
    public function __construct(string $status = Values::NONE)
    {
        $this->options['status'] = $status;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Verify.V2.CreateWebhookOptions ' . $options . ']';
    }
}

class UpdateWebhookOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, array $eventTypes = Values::ARRAY_NONE, string $webhookUrl = Values::NONE, string $status = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['eventTypes'] = $eventTypes;
        $this->options['webhookUrl'] = $webhookUrl;
        $this->options['status'] = $status;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setEventTypes(array $eventTypes): self
    {
        $this->options['eventTypes'] = $eventTypes;
        return $this;
    }

    public function setWebhookUrl(string $webhookUrl): self
    {
        $this->options['webhookUrl'] = $webhookUrl;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Verify.V2.UpdateWebhookOptions ' . $options . ']';
    }
}