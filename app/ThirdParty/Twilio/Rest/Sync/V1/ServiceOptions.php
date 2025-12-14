<?php

namespace Twilio\Rest\Sync\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ServiceOptions
{
    public static function create(string $friendlyName = Values::NONE, string $webhookUrl = Values::NONE, bool $reachabilityWebhooksEnabled = Values::NONE, bool $aclEnabled = Values::NONE, bool $reachabilityDebouncingEnabled = Values::NONE, int $reachabilityDebouncingWindow = Values::NONE, bool $webhooksFromRestEnabled = Values::NONE): CreateServiceOptions
    {
        return new CreateServiceOptions($friendlyName, $webhookUrl, $reachabilityWebhooksEnabled, $aclEnabled, $reachabilityDebouncingEnabled, $reachabilityDebouncingWindow, $webhooksFromRestEnabled);
    }

    public static function update(string $webhookUrl = Values::NONE, string $friendlyName = Values::NONE, bool $reachabilityWebhooksEnabled = Values::NONE, bool $aclEnabled = Values::NONE, bool $reachabilityDebouncingEnabled = Values::NONE, int $reachabilityDebouncingWindow = Values::NONE, bool $webhooksFromRestEnabled = Values::NONE): UpdateServiceOptions
    {
        return new UpdateServiceOptions($webhookUrl, $friendlyName, $reachabilityWebhooksEnabled, $aclEnabled, $reachabilityDebouncingEnabled, $reachabilityDebouncingWindow, $webhooksFromRestEnabled);
    }
}

class CreateServiceOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $webhookUrl = Values::NONE, bool $reachabilityWebhooksEnabled = Values::NONE, bool $aclEnabled = Values::NONE, bool $reachabilityDebouncingEnabled = Values::NONE, int $reachabilityDebouncingWindow = Values::NONE, bool $webhooksFromRestEnabled = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['webhookUrl'] = $webhookUrl;
        $this->options['reachabilityWebhooksEnabled'] = $reachabilityWebhooksEnabled;
        $this->options['aclEnabled'] = $aclEnabled;
        $this->options['reachabilityDebouncingEnabled'] = $reachabilityDebouncingEnabled;
        $this->options['reachabilityDebouncingWindow'] = $reachabilityDebouncingWindow;
        $this->options['webhooksFromRestEnabled'] = $webhooksFromRestEnabled;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setWebhookUrl(string $webhookUrl): self
    {
        $this->options['webhookUrl'] = $webhookUrl;
        return $this;
    }

    public function setReachabilityWebhooksEnabled(bool $reachabilityWebhooksEnabled): self
    {
        $this->options['reachabilityWebhooksEnabled'] = $reachabilityWebhooksEnabled;
        return $this;
    }

    public function setAclEnabled(bool $aclEnabled): self
    {
        $this->options['aclEnabled'] = $aclEnabled;
        return $this;
    }

    public function setReachabilityDebouncingEnabled(bool $reachabilityDebouncingEnabled): self
    {
        $this->options['reachabilityDebouncingEnabled'] = $reachabilityDebouncingEnabled;
        return $this;
    }

    public function setReachabilityDebouncingWindow(int $reachabilityDebouncingWindow): self
    {
        $this->options['reachabilityDebouncingWindow'] = $reachabilityDebouncingWindow;
        return $this;
    }

    public function setWebhooksFromRestEnabled(bool $webhooksFromRestEnabled): self
    {
        $this->options['webhooksFromRestEnabled'] = $webhooksFromRestEnabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Sync.V1.CreateServiceOptions ' . $options . ']';
    }
}

class UpdateServiceOptions extends Options
{
    public function __construct(string $webhookUrl = Values::NONE, string $friendlyName = Values::NONE, bool $reachabilityWebhooksEnabled = Values::NONE, bool $aclEnabled = Values::NONE, bool $reachabilityDebouncingEnabled = Values::NONE, int $reachabilityDebouncingWindow = Values::NONE, bool $webhooksFromRestEnabled = Values::NONE)
    {
        $this->options['webhookUrl'] = $webhookUrl;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['reachabilityWebhooksEnabled'] = $reachabilityWebhooksEnabled;
        $this->options['aclEnabled'] = $aclEnabled;
        $this->options['reachabilityDebouncingEnabled'] = $reachabilityDebouncingEnabled;
        $this->options['reachabilityDebouncingWindow'] = $reachabilityDebouncingWindow;
        $this->options['webhooksFromRestEnabled'] = $webhooksFromRestEnabled;
    }

    public function setWebhookUrl(string $webhookUrl): self
    {
        $this->options['webhookUrl'] = $webhookUrl;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setReachabilityWebhooksEnabled(bool $reachabilityWebhooksEnabled): self
    {
        $this->options['reachabilityWebhooksEnabled'] = $reachabilityWebhooksEnabled;
        return $this;
    }

    public function setAclEnabled(bool $aclEnabled): self
    {
        $this->options['aclEnabled'] = $aclEnabled;
        return $this;
    }

    public function setReachabilityDebouncingEnabled(bool $reachabilityDebouncingEnabled): self
    {
        $this->options['reachabilityDebouncingEnabled'] = $reachabilityDebouncingEnabled;
        return $this;
    }

    public function setReachabilityDebouncingWindow(int $reachabilityDebouncingWindow): self
    {
        $this->options['reachabilityDebouncingWindow'] = $reachabilityDebouncingWindow;
        return $this;
    }

    public function setWebhooksFromRestEnabled(bool $webhooksFromRestEnabled): self
    {
        $this->options['webhooksFromRestEnabled'] = $webhooksFromRestEnabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Sync.V1.UpdateServiceOptions ' . $options . ']';
    }
}