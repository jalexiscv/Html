<?php

namespace Twilio\Rest\Conversations\V1\Configuration;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class WebhookOptions
{
    public static function update(string $method = Values::NONE, array $filters = Values::ARRAY_NONE, string $preWebhookUrl = Values::NONE, string $postWebhookUrl = Values::NONE, string $target = Values::NONE): UpdateWebhookOptions
    {
        return new UpdateWebhookOptions($method, $filters, $preWebhookUrl, $postWebhookUrl, $target);
    }
}

class UpdateWebhookOptions extends Options
{
    public function __construct(string $method = Values::NONE, array $filters = Values::ARRAY_NONE, string $preWebhookUrl = Values::NONE, string $postWebhookUrl = Values::NONE, string $target = Values::NONE)
    {
        $this->options['method'] = $method;
        $this->options['filters'] = $filters;
        $this->options['preWebhookUrl'] = $preWebhookUrl;
        $this->options['postWebhookUrl'] = $postWebhookUrl;
        $this->options['target'] = $target;
    }

    public function setMethod(string $method): self
    {
        $this->options['method'] = $method;
        return $this;
    }

    public function setFilters(array $filters): self
    {
        $this->options['filters'] = $filters;
        return $this;
    }

    public function setPreWebhookUrl(string $preWebhookUrl): self
    {
        $this->options['preWebhookUrl'] = $preWebhookUrl;
        return $this;
    }

    public function setPostWebhookUrl(string $postWebhookUrl): self
    {
        $this->options['postWebhookUrl'] = $postWebhookUrl;
        return $this;
    }

    public function setTarget(string $target): self
    {
        $this->options['target'] = $target;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Conversations.V1.UpdateWebhookOptions ' . $options . ']';
    }
}