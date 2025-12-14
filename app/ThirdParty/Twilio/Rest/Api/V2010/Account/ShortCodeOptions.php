<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ShortCodeOptions
{
    public static function update(string $friendlyName = Values::NONE, string $apiVersion = Values::NONE, string $smsUrl = Values::NONE, string $smsMethod = Values::NONE, string $smsFallbackUrl = Values::NONE, string $smsFallbackMethod = Values::NONE): UpdateShortCodeOptions
    {
        return new UpdateShortCodeOptions($friendlyName, $apiVersion, $smsUrl, $smsMethod, $smsFallbackUrl, $smsFallbackMethod);
    }

    public static function read(string $friendlyName = Values::NONE, string $shortCode = Values::NONE): ReadShortCodeOptions
    {
        return new ReadShortCodeOptions($friendlyName, $shortCode);
    }
}

class UpdateShortCodeOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $apiVersion = Values::NONE, string $smsUrl = Values::NONE, string $smsMethod = Values::NONE, string $smsFallbackUrl = Values::NONE, string $smsFallbackMethod = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['apiVersion'] = $apiVersion;
        $this->options['smsUrl'] = $smsUrl;
        $this->options['smsMethod'] = $smsMethod;
        $this->options['smsFallbackUrl'] = $smsFallbackUrl;
        $this->options['smsFallbackMethod'] = $smsFallbackMethod;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setApiVersion(string $apiVersion): self
    {
        $this->options['apiVersion'] = $apiVersion;
        return $this;
    }

    public function setSmsUrl(string $smsUrl): self
    {
        $this->options['smsUrl'] = $smsUrl;
        return $this;
    }

    public function setSmsMethod(string $smsMethod): self
    {
        $this->options['smsMethod'] = $smsMethod;
        return $this;
    }

    public function setSmsFallbackUrl(string $smsFallbackUrl): self
    {
        $this->options['smsFallbackUrl'] = $smsFallbackUrl;
        return $this;
    }

    public function setSmsFallbackMethod(string $smsFallbackMethod): self
    {
        $this->options['smsFallbackMethod'] = $smsFallbackMethod;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.UpdateShortCodeOptions ' . $options . ']';
    }
}

class ReadShortCodeOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $shortCode = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['shortCode'] = $shortCode;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setShortCode(string $shortCode): self
    {
        $this->options['shortCode'] = $shortCode;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.ReadShortCodeOptions ' . $options . ']';
    }
}