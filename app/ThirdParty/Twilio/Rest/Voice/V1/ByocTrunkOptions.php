<?php

namespace Twilio\Rest\Voice\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ByocTrunkOptions
{
    public static function create(string $friendlyName = Values::NONE, string $voiceUrl = Values::NONE, string $voiceMethod = Values::NONE, string $voiceFallbackUrl = Values::NONE, string $voiceFallbackMethod = Values::NONE, string $statusCallbackUrl = Values::NONE, string $statusCallbackMethod = Values::NONE, bool $cnamLookupEnabled = Values::NONE, string $connectionPolicySid = Values::NONE, string $fromDomainSid = Values::NONE): CreateByocTrunkOptions
    {
        return new CreateByocTrunkOptions($friendlyName, $voiceUrl, $voiceMethod, $voiceFallbackUrl, $voiceFallbackMethod, $statusCallbackUrl, $statusCallbackMethod, $cnamLookupEnabled, $connectionPolicySid, $fromDomainSid);
    }

    public static function update(string $friendlyName = Values::NONE, string $voiceUrl = Values::NONE, string $voiceMethod = Values::NONE, string $voiceFallbackUrl = Values::NONE, string $voiceFallbackMethod = Values::NONE, string $statusCallbackUrl = Values::NONE, string $statusCallbackMethod = Values::NONE, bool $cnamLookupEnabled = Values::NONE, string $connectionPolicySid = Values::NONE, string $fromDomainSid = Values::NONE): UpdateByocTrunkOptions
    {
        return new UpdateByocTrunkOptions($friendlyName, $voiceUrl, $voiceMethod, $voiceFallbackUrl, $voiceFallbackMethod, $statusCallbackUrl, $statusCallbackMethod, $cnamLookupEnabled, $connectionPolicySid, $fromDomainSid);
    }
}

class CreateByocTrunkOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $voiceUrl = Values::NONE, string $voiceMethod = Values::NONE, string $voiceFallbackUrl = Values::NONE, string $voiceFallbackMethod = Values::NONE, string $statusCallbackUrl = Values::NONE, string $statusCallbackMethod = Values::NONE, bool $cnamLookupEnabled = Values::NONE, string $connectionPolicySid = Values::NONE, string $fromDomainSid = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['voiceUrl'] = $voiceUrl;
        $this->options['voiceMethod'] = $voiceMethod;
        $this->options['voiceFallbackUrl'] = $voiceFallbackUrl;
        $this->options['voiceFallbackMethod'] = $voiceFallbackMethod;
        $this->options['statusCallbackUrl'] = $statusCallbackUrl;
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        $this->options['cnamLookupEnabled'] = $cnamLookupEnabled;
        $this->options['connectionPolicySid'] = $connectionPolicySid;
        $this->options['fromDomainSid'] = $fromDomainSid;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setVoiceUrl(string $voiceUrl): self
    {
        $this->options['voiceUrl'] = $voiceUrl;
        return $this;
    }

    public function setVoiceMethod(string $voiceMethod): self
    {
        $this->options['voiceMethod'] = $voiceMethod;
        return $this;
    }

    public function setVoiceFallbackUrl(string $voiceFallbackUrl): self
    {
        $this->options['voiceFallbackUrl'] = $voiceFallbackUrl;
        return $this;
    }

    public function setVoiceFallbackMethod(string $voiceFallbackMethod): self
    {
        $this->options['voiceFallbackMethod'] = $voiceFallbackMethod;
        return $this;
    }

    public function setStatusCallbackUrl(string $statusCallbackUrl): self
    {
        $this->options['statusCallbackUrl'] = $statusCallbackUrl;
        return $this;
    }

    public function setStatusCallbackMethod(string $statusCallbackMethod): self
    {
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        return $this;
    }

    public function setCnamLookupEnabled(bool $cnamLookupEnabled): self
    {
        $this->options['cnamLookupEnabled'] = $cnamLookupEnabled;
        return $this;
    }

    public function setConnectionPolicySid(string $connectionPolicySid): self
    {
        $this->options['connectionPolicySid'] = $connectionPolicySid;
        return $this;
    }

    public function setFromDomainSid(string $fromDomainSid): self
    {
        $this->options['fromDomainSid'] = $fromDomainSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Voice.V1.CreateByocTrunkOptions ' . $options . ']';
    }
}

class UpdateByocTrunkOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $voiceUrl = Values::NONE, string $voiceMethod = Values::NONE, string $voiceFallbackUrl = Values::NONE, string $voiceFallbackMethod = Values::NONE, string $statusCallbackUrl = Values::NONE, string $statusCallbackMethod = Values::NONE, bool $cnamLookupEnabled = Values::NONE, string $connectionPolicySid = Values::NONE, string $fromDomainSid = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['voiceUrl'] = $voiceUrl;
        $this->options['voiceMethod'] = $voiceMethod;
        $this->options['voiceFallbackUrl'] = $voiceFallbackUrl;
        $this->options['voiceFallbackMethod'] = $voiceFallbackMethod;
        $this->options['statusCallbackUrl'] = $statusCallbackUrl;
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        $this->options['cnamLookupEnabled'] = $cnamLookupEnabled;
        $this->options['connectionPolicySid'] = $connectionPolicySid;
        $this->options['fromDomainSid'] = $fromDomainSid;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setVoiceUrl(string $voiceUrl): self
    {
        $this->options['voiceUrl'] = $voiceUrl;
        return $this;
    }

    public function setVoiceMethod(string $voiceMethod): self
    {
        $this->options['voiceMethod'] = $voiceMethod;
        return $this;
    }

    public function setVoiceFallbackUrl(string $voiceFallbackUrl): self
    {
        $this->options['voiceFallbackUrl'] = $voiceFallbackUrl;
        return $this;
    }

    public function setVoiceFallbackMethod(string $voiceFallbackMethod): self
    {
        $this->options['voiceFallbackMethod'] = $voiceFallbackMethod;
        return $this;
    }

    public function setStatusCallbackUrl(string $statusCallbackUrl): self
    {
        $this->options['statusCallbackUrl'] = $statusCallbackUrl;
        return $this;
    }

    public function setStatusCallbackMethod(string $statusCallbackMethod): self
    {
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        return $this;
    }

    public function setCnamLookupEnabled(bool $cnamLookupEnabled): self
    {
        $this->options['cnamLookupEnabled'] = $cnamLookupEnabled;
        return $this;
    }

    public function setConnectionPolicySid(string $connectionPolicySid): self
    {
        $this->options['connectionPolicySid'] = $connectionPolicySid;
        return $this;
    }

    public function setFromDomainSid(string $fromDomainSid): self
    {
        $this->options['fromDomainSid'] = $fromDomainSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Voice.V1.UpdateByocTrunkOptions ' . $options . ']';
    }
}