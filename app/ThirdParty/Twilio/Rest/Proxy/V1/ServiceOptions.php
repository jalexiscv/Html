<?php

namespace Twilio\Rest\Proxy\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ServiceOptions
{
    public static function create(int $defaultTtl = Values::NONE, string $callbackUrl = Values::NONE, string $geoMatchLevel = Values::NONE, string $numberSelectionBehavior = Values::NONE, string $interceptCallbackUrl = Values::NONE, string $outOfSessionCallbackUrl = Values::NONE, string $chatInstanceSid = Values::NONE): CreateServiceOptions
    {
        return new CreateServiceOptions($defaultTtl, $callbackUrl, $geoMatchLevel, $numberSelectionBehavior, $interceptCallbackUrl, $outOfSessionCallbackUrl, $chatInstanceSid);
    }

    public static function update(string $uniqueName = Values::NONE, int $defaultTtl = Values::NONE, string $callbackUrl = Values::NONE, string $geoMatchLevel = Values::NONE, string $numberSelectionBehavior = Values::NONE, string $interceptCallbackUrl = Values::NONE, string $outOfSessionCallbackUrl = Values::NONE, string $chatInstanceSid = Values::NONE): UpdateServiceOptions
    {
        return new UpdateServiceOptions($uniqueName, $defaultTtl, $callbackUrl, $geoMatchLevel, $numberSelectionBehavior, $interceptCallbackUrl, $outOfSessionCallbackUrl, $chatInstanceSid);
    }
}

class CreateServiceOptions extends Options
{
    public function __construct(int $defaultTtl = Values::NONE, string $callbackUrl = Values::NONE, string $geoMatchLevel = Values::NONE, string $numberSelectionBehavior = Values::NONE, string $interceptCallbackUrl = Values::NONE, string $outOfSessionCallbackUrl = Values::NONE, string $chatInstanceSid = Values::NONE)
    {
        $this->options['defaultTtl'] = $defaultTtl;
        $this->options['callbackUrl'] = $callbackUrl;
        $this->options['geoMatchLevel'] = $geoMatchLevel;
        $this->options['numberSelectionBehavior'] = $numberSelectionBehavior;
        $this->options['interceptCallbackUrl'] = $interceptCallbackUrl;
        $this->options['outOfSessionCallbackUrl'] = $outOfSessionCallbackUrl;
        $this->options['chatInstanceSid'] = $chatInstanceSid;
    }

    public function setDefaultTtl(int $defaultTtl): self
    {
        $this->options['defaultTtl'] = $defaultTtl;
        return $this;
    }

    public function setCallbackUrl(string $callbackUrl): self
    {
        $this->options['callbackUrl'] = $callbackUrl;
        return $this;
    }

    public function setGeoMatchLevel(string $geoMatchLevel): self
    {
        $this->options['geoMatchLevel'] = $geoMatchLevel;
        return $this;
    }

    public function setNumberSelectionBehavior(string $numberSelectionBehavior): self
    {
        $this->options['numberSelectionBehavior'] = $numberSelectionBehavior;
        return $this;
    }

    public function setInterceptCallbackUrl(string $interceptCallbackUrl): self
    {
        $this->options['interceptCallbackUrl'] = $interceptCallbackUrl;
        return $this;
    }

    public function setOutOfSessionCallbackUrl(string $outOfSessionCallbackUrl): self
    {
        $this->options['outOfSessionCallbackUrl'] = $outOfSessionCallbackUrl;
        return $this;
    }

    public function setChatInstanceSid(string $chatInstanceSid): self
    {
        $this->options['chatInstanceSid'] = $chatInstanceSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Proxy.V1.CreateServiceOptions ' . $options . ']';
    }
}

class UpdateServiceOptions extends Options
{
    public function __construct(string $uniqueName = Values::NONE, int $defaultTtl = Values::NONE, string $callbackUrl = Values::NONE, string $geoMatchLevel = Values::NONE, string $numberSelectionBehavior = Values::NONE, string $interceptCallbackUrl = Values::NONE, string $outOfSessionCallbackUrl = Values::NONE, string $chatInstanceSid = Values::NONE)
    {
        $this->options['uniqueName'] = $uniqueName;
        $this->options['defaultTtl'] = $defaultTtl;
        $this->options['callbackUrl'] = $callbackUrl;
        $this->options['geoMatchLevel'] = $geoMatchLevel;
        $this->options['numberSelectionBehavior'] = $numberSelectionBehavior;
        $this->options['interceptCallbackUrl'] = $interceptCallbackUrl;
        $this->options['outOfSessionCallbackUrl'] = $outOfSessionCallbackUrl;
        $this->options['chatInstanceSid'] = $chatInstanceSid;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setDefaultTtl(int $defaultTtl): self
    {
        $this->options['defaultTtl'] = $defaultTtl;
        return $this;
    }

    public function setCallbackUrl(string $callbackUrl): self
    {
        $this->options['callbackUrl'] = $callbackUrl;
        return $this;
    }

    public function setGeoMatchLevel(string $geoMatchLevel): self
    {
        $this->options['geoMatchLevel'] = $geoMatchLevel;
        return $this;
    }

    public function setNumberSelectionBehavior(string $numberSelectionBehavior): self
    {
        $this->options['numberSelectionBehavior'] = $numberSelectionBehavior;
        return $this;
    }

    public function setInterceptCallbackUrl(string $interceptCallbackUrl): self
    {
        $this->options['interceptCallbackUrl'] = $interceptCallbackUrl;
        return $this;
    }

    public function setOutOfSessionCallbackUrl(string $outOfSessionCallbackUrl): self
    {
        $this->options['outOfSessionCallbackUrl'] = $outOfSessionCallbackUrl;
        return $this;
    }

    public function setChatInstanceSid(string $chatInstanceSid): self
    {
        $this->options['chatInstanceSid'] = $chatInstanceSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Proxy.V1.UpdateServiceOptions ' . $options . ']';
    }
}