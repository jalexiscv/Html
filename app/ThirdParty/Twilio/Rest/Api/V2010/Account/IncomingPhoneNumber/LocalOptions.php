<?php

namespace Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class LocalOptions
{
    public static function read(bool $beta = Values::NONE, string $friendlyName = Values::NONE, string $phoneNumber = Values::NONE, string $origin = Values::NONE): ReadLocalOptions
    {
        return new ReadLocalOptions($beta, $friendlyName, $phoneNumber, $origin);
    }

    public static function create(string $apiVersion = Values::NONE, string $friendlyName = Values::NONE, string $smsApplicationSid = Values::NONE, string $smsFallbackMethod = Values::NONE, string $smsFallbackUrl = Values::NONE, string $smsMethod = Values::NONE, string $smsUrl = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE, string $voiceApplicationSid = Values::NONE, bool $voiceCallerIdLookup = Values::NONE, string $voiceFallbackMethod = Values::NONE, string $voiceFallbackUrl = Values::NONE, string $voiceMethod = Values::NONE, string $voiceUrl = Values::NONE, string $identitySid = Values::NONE, string $addressSid = Values::NONE, string $emergencyStatus = Values::NONE, string $emergencyAddressSid = Values::NONE, string $trunkSid = Values::NONE, string $voiceReceiveMode = Values::NONE, string $bundleSid = Values::NONE): CreateLocalOptions
    {
        return new CreateLocalOptions($apiVersion, $friendlyName, $smsApplicationSid, $smsFallbackMethod, $smsFallbackUrl, $smsMethod, $smsUrl, $statusCallback, $statusCallbackMethod, $voiceApplicationSid, $voiceCallerIdLookup, $voiceFallbackMethod, $voiceFallbackUrl, $voiceMethod, $voiceUrl, $identitySid, $addressSid, $emergencyStatus, $emergencyAddressSid, $trunkSid, $voiceReceiveMode, $bundleSid);
    }
}

class ReadLocalOptions extends Options
{
    public function __construct(bool $beta = Values::NONE, string $friendlyName = Values::NONE, string $phoneNumber = Values::NONE, string $origin = Values::NONE)
    {
        $this->options['beta'] = $beta;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['phoneNumber'] = $phoneNumber;
        $this->options['origin'] = $origin;
    }

    public function setBeta(bool $beta): self
    {
        $this->options['beta'] = $beta;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->options['phoneNumber'] = $phoneNumber;
        return $this;
    }

    public function setOrigin(string $origin): self
    {
        $this->options['origin'] = $origin;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.ReadLocalOptions ' . $options . ']';
    }
}

class CreateLocalOptions extends Options
{
    public function __construct(string $apiVersion = Values::NONE, string $friendlyName = Values::NONE, string $smsApplicationSid = Values::NONE, string $smsFallbackMethod = Values::NONE, string $smsFallbackUrl = Values::NONE, string $smsMethod = Values::NONE, string $smsUrl = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE, string $voiceApplicationSid = Values::NONE, bool $voiceCallerIdLookup = Values::NONE, string $voiceFallbackMethod = Values::NONE, string $voiceFallbackUrl = Values::NONE, string $voiceMethod = Values::NONE, string $voiceUrl = Values::NONE, string $identitySid = Values::NONE, string $addressSid = Values::NONE, string $emergencyStatus = Values::NONE, string $emergencyAddressSid = Values::NONE, string $trunkSid = Values::NONE, string $voiceReceiveMode = Values::NONE, string $bundleSid = Values::NONE)
    {
        $this->options['apiVersion'] = $apiVersion;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['smsApplicationSid'] = $smsApplicationSid;
        $this->options['smsFallbackMethod'] = $smsFallbackMethod;
        $this->options['smsFallbackUrl'] = $smsFallbackUrl;
        $this->options['smsMethod'] = $smsMethod;
        $this->options['smsUrl'] = $smsUrl;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        $this->options['voiceApplicationSid'] = $voiceApplicationSid;
        $this->options['voiceCallerIdLookup'] = $voiceCallerIdLookup;
        $this->options['voiceFallbackMethod'] = $voiceFallbackMethod;
        $this->options['voiceFallbackUrl'] = $voiceFallbackUrl;
        $this->options['voiceMethod'] = $voiceMethod;
        $this->options['voiceUrl'] = $voiceUrl;
        $this->options['identitySid'] = $identitySid;
        $this->options['addressSid'] = $addressSid;
        $this->options['emergencyStatus'] = $emergencyStatus;
        $this->options['emergencyAddressSid'] = $emergencyAddressSid;
        $this->options['trunkSid'] = $trunkSid;
        $this->options['voiceReceiveMode'] = $voiceReceiveMode;
        $this->options['bundleSid'] = $bundleSid;
    }

    public function setApiVersion(string $apiVersion): self
    {
        $this->options['apiVersion'] = $apiVersion;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setSmsApplicationSid(string $smsApplicationSid): self
    {
        $this->options['smsApplicationSid'] = $smsApplicationSid;
        return $this;
    }

    public function setSmsFallbackMethod(string $smsFallbackMethod): self
    {
        $this->options['smsFallbackMethod'] = $smsFallbackMethod;
        return $this;
    }

    public function setSmsFallbackUrl(string $smsFallbackUrl): self
    {
        $this->options['smsFallbackUrl'] = $smsFallbackUrl;
        return $this;
    }

    public function setSmsMethod(string $smsMethod): self
    {
        $this->options['smsMethod'] = $smsMethod;
        return $this;
    }

    public function setSmsUrl(string $smsUrl): self
    {
        $this->options['smsUrl'] = $smsUrl;
        return $this;
    }

    public function setStatusCallback(string $statusCallback): self
    {
        $this->options['statusCallback'] = $statusCallback;
        return $this;
    }

    public function setStatusCallbackMethod(string $statusCallbackMethod): self
    {
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        return $this;
    }

    public function setVoiceApplicationSid(string $voiceApplicationSid): self
    {
        $this->options['voiceApplicationSid'] = $voiceApplicationSid;
        return $this;
    }

    public function setVoiceCallerIdLookup(bool $voiceCallerIdLookup): self
    {
        $this->options['voiceCallerIdLookup'] = $voiceCallerIdLookup;
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

    public function setVoiceUrl(string $voiceUrl): self
    {
        $this->options['voiceUrl'] = $voiceUrl;
        return $this;
    }

    public function setIdentitySid(string $identitySid): self
    {
        $this->options['identitySid'] = $identitySid;
        return $this;
    }

    public function setAddressSid(string $addressSid): self
    {
        $this->options['addressSid'] = $addressSid;
        return $this;
    }

    public function setEmergencyStatus(string $emergencyStatus): self
    {
        $this->options['emergencyStatus'] = $emergencyStatus;
        return $this;
    }

    public function setEmergencyAddressSid(string $emergencyAddressSid): self
    {
        $this->options['emergencyAddressSid'] = $emergencyAddressSid;
        return $this;
    }

    public function setTrunkSid(string $trunkSid): self
    {
        $this->options['trunkSid'] = $trunkSid;
        return $this;
    }

    public function setVoiceReceiveMode(string $voiceReceiveMode): self
    {
        $this->options['voiceReceiveMode'] = $voiceReceiveMode;
        return $this;
    }

    public function setBundleSid(string $bundleSid): self
    {
        $this->options['bundleSid'] = $bundleSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.CreateLocalOptions ' . $options . ']';
    }
}