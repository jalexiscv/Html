<?php

namespace Twilio\Rest\Api\V2010\Account\Sip;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class DomainOptions
{
    public static function create(string $friendlyName = Values::NONE, string $voiceUrl = Values::NONE, string $voiceMethod = Values::NONE, string $voiceFallbackUrl = Values::NONE, string $voiceFallbackMethod = Values::NONE, string $voiceStatusCallbackUrl = Values::NONE, string $voiceStatusCallbackMethod = Values::NONE, bool $sipRegistration = Values::NONE, bool $emergencyCallingEnabled = Values::NONE, bool $secure = Values::NONE, string $byocTrunkSid = Values::NONE, string $emergencyCallerSid = Values::NONE): CreateDomainOptions
    {
        return new CreateDomainOptions($friendlyName, $voiceUrl, $voiceMethod, $voiceFallbackUrl, $voiceFallbackMethod, $voiceStatusCallbackUrl, $voiceStatusCallbackMethod, $sipRegistration, $emergencyCallingEnabled, $secure, $byocTrunkSid, $emergencyCallerSid);
    }

    public static function update(string $friendlyName = Values::NONE, string $voiceFallbackMethod = Values::NONE, string $voiceFallbackUrl = Values::NONE, string $voiceMethod = Values::NONE, string $voiceStatusCallbackMethod = Values::NONE, string $voiceStatusCallbackUrl = Values::NONE, string $voiceUrl = Values::NONE, bool $sipRegistration = Values::NONE, string $domainName = Values::NONE, bool $emergencyCallingEnabled = Values::NONE, bool $secure = Values::NONE, string $byocTrunkSid = Values::NONE, string $emergencyCallerSid = Values::NONE): UpdateDomainOptions
    {
        return new UpdateDomainOptions($friendlyName, $voiceFallbackMethod, $voiceFallbackUrl, $voiceMethod, $voiceStatusCallbackMethod, $voiceStatusCallbackUrl, $voiceUrl, $sipRegistration, $domainName, $emergencyCallingEnabled, $secure, $byocTrunkSid, $emergencyCallerSid);
    }
}

class CreateDomainOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $voiceUrl = Values::NONE, string $voiceMethod = Values::NONE, string $voiceFallbackUrl = Values::NONE, string $voiceFallbackMethod = Values::NONE, string $voiceStatusCallbackUrl = Values::NONE, string $voiceStatusCallbackMethod = Values::NONE, bool $sipRegistration = Values::NONE, bool $emergencyCallingEnabled = Values::NONE, bool $secure = Values::NONE, string $byocTrunkSid = Values::NONE, string $emergencyCallerSid = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['voiceUrl'] = $voiceUrl;
        $this->options['voiceMethod'] = $voiceMethod;
        $this->options['voiceFallbackUrl'] = $voiceFallbackUrl;
        $this->options['voiceFallbackMethod'] = $voiceFallbackMethod;
        $this->options['voiceStatusCallbackUrl'] = $voiceStatusCallbackUrl;
        $this->options['voiceStatusCallbackMethod'] = $voiceStatusCallbackMethod;
        $this->options['sipRegistration'] = $sipRegistration;
        $this->options['emergencyCallingEnabled'] = $emergencyCallingEnabled;
        $this->options['secure'] = $secure;
        $this->options['byocTrunkSid'] = $byocTrunkSid;
        $this->options['emergencyCallerSid'] = $emergencyCallerSid;
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

    public function setVoiceStatusCallbackUrl(string $voiceStatusCallbackUrl): self
    {
        $this->options['voiceStatusCallbackUrl'] = $voiceStatusCallbackUrl;
        return $this;
    }

    public function setVoiceStatusCallbackMethod(string $voiceStatusCallbackMethod): self
    {
        $this->options['voiceStatusCallbackMethod'] = $voiceStatusCallbackMethod;
        return $this;
    }

    public function setSipRegistration(bool $sipRegistration): self
    {
        $this->options['sipRegistration'] = $sipRegistration;
        return $this;
    }

    public function setEmergencyCallingEnabled(bool $emergencyCallingEnabled): self
    {
        $this->options['emergencyCallingEnabled'] = $emergencyCallingEnabled;
        return $this;
    }

    public function setSecure(bool $secure): self
    {
        $this->options['secure'] = $secure;
        return $this;
    }

    public function setByocTrunkSid(string $byocTrunkSid): self
    {
        $this->options['byocTrunkSid'] = $byocTrunkSid;
        return $this;
    }

    public function setEmergencyCallerSid(string $emergencyCallerSid): self
    {
        $this->options['emergencyCallerSid'] = $emergencyCallerSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.CreateDomainOptions ' . $options . ']';
    }
}

class UpdateDomainOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $voiceFallbackMethod = Values::NONE, string $voiceFallbackUrl = Values::NONE, string $voiceMethod = Values::NONE, string $voiceStatusCallbackMethod = Values::NONE, string $voiceStatusCallbackUrl = Values::NONE, string $voiceUrl = Values::NONE, bool $sipRegistration = Values::NONE, string $domainName = Values::NONE, bool $emergencyCallingEnabled = Values::NONE, bool $secure = Values::NONE, string $byocTrunkSid = Values::NONE, string $emergencyCallerSid = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['voiceFallbackMethod'] = $voiceFallbackMethod;
        $this->options['voiceFallbackUrl'] = $voiceFallbackUrl;
        $this->options['voiceMethod'] = $voiceMethod;
        $this->options['voiceStatusCallbackMethod'] = $voiceStatusCallbackMethod;
        $this->options['voiceStatusCallbackUrl'] = $voiceStatusCallbackUrl;
        $this->options['voiceUrl'] = $voiceUrl;
        $this->options['sipRegistration'] = $sipRegistration;
        $this->options['domainName'] = $domainName;
        $this->options['emergencyCallingEnabled'] = $emergencyCallingEnabled;
        $this->options['secure'] = $secure;
        $this->options['byocTrunkSid'] = $byocTrunkSid;
        $this->options['emergencyCallerSid'] = $emergencyCallerSid;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setVoiceFallbackMethod(string $voiceFallbackMethod): self
    {
        $this->options['voiceFallbackMethod'] = $voiceFallbackMethod;
        return $this;
    }

    public function setVoiceFallbackUrl(string $voiceFallbackUrl): self
    {
        $this->options['voiceFallbackUrl'] = $voiceFallbackUrl;
        return $this;
    }

    public function setVoiceMethod(string $voiceMethod): self
    {
        $this->options['voiceMethod'] = $voiceMethod;
        return $this;
    }

    public function setVoiceStatusCallbackMethod(string $voiceStatusCallbackMethod): self
    {
        $this->options['voiceStatusCallbackMethod'] = $voiceStatusCallbackMethod;
        return $this;
    }

    public function setVoiceStatusCallbackUrl(string $voiceStatusCallbackUrl): self
    {
        $this->options['voiceStatusCallbackUrl'] = $voiceStatusCallbackUrl;
        return $this;
    }

    public function setVoiceUrl(string $voiceUrl): self
    {
        $this->options['voiceUrl'] = $voiceUrl;
        return $this;
    }

    public function setSipRegistration(bool $sipRegistration): self
    {
        $this->options['sipRegistration'] = $sipRegistration;
        return $this;
    }

    public function setDomainName(string $domainName): self
    {
        $this->options['domainName'] = $domainName;
        return $this;
    }

    public function setEmergencyCallingEnabled(bool $emergencyCallingEnabled): self
    {
        $this->options['emergencyCallingEnabled'] = $emergencyCallingEnabled;
        return $this;
    }

    public function setSecure(bool $secure): self
    {
        $this->options['secure'] = $secure;
        return $this;
    }

    public function setByocTrunkSid(string $byocTrunkSid): self
    {
        $this->options['byocTrunkSid'] = $byocTrunkSid;
        return $this;
    }

    public function setEmergencyCallerSid(string $emergencyCallerSid): self
    {
        $this->options['emergencyCallerSid'] = $emergencyCallerSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.UpdateDomainOptions ' . $options . ']';
    }
}