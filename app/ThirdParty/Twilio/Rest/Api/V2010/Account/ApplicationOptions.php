<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ApplicationOptions
{
    public static function create(string $apiVersion = Values::NONE, string $voiceUrl = Values::NONE, string $voiceMethod = Values::NONE, string $voiceFallbackUrl = Values::NONE, string $voiceFallbackMethod = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE, bool $voiceCallerIdLookup = Values::NONE, string $smsUrl = Values::NONE, string $smsMethod = Values::NONE, string $smsFallbackUrl = Values::NONE, string $smsFallbackMethod = Values::NONE, string $smsStatusCallback = Values::NONE, string $messageStatusCallback = Values::NONE, string $friendlyName = Values::NONE): CreateApplicationOptions
    {
        return new CreateApplicationOptions($apiVersion, $voiceUrl, $voiceMethod, $voiceFallbackUrl, $voiceFallbackMethod, $statusCallback, $statusCallbackMethod, $voiceCallerIdLookup, $smsUrl, $smsMethod, $smsFallbackUrl, $smsFallbackMethod, $smsStatusCallback, $messageStatusCallback, $friendlyName);
    }

    public static function read(string $friendlyName = Values::NONE): ReadApplicationOptions
    {
        return new ReadApplicationOptions($friendlyName);
    }

    public static function update(string $friendlyName = Values::NONE, string $apiVersion = Values::NONE, string $voiceUrl = Values::NONE, string $voiceMethod = Values::NONE, string $voiceFallbackUrl = Values::NONE, string $voiceFallbackMethod = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE, bool $voiceCallerIdLookup = Values::NONE, string $smsUrl = Values::NONE, string $smsMethod = Values::NONE, string $smsFallbackUrl = Values::NONE, string $smsFallbackMethod = Values::NONE, string $smsStatusCallback = Values::NONE, string $messageStatusCallback = Values::NONE): UpdateApplicationOptions
    {
        return new UpdateApplicationOptions($friendlyName, $apiVersion, $voiceUrl, $voiceMethod, $voiceFallbackUrl, $voiceFallbackMethod, $statusCallback, $statusCallbackMethod, $voiceCallerIdLookup, $smsUrl, $smsMethod, $smsFallbackUrl, $smsFallbackMethod, $smsStatusCallback, $messageStatusCallback);
    }
}

class CreateApplicationOptions extends Options
{
    public function __construct(string $apiVersion = Values::NONE, string $voiceUrl = Values::NONE, string $voiceMethod = Values::NONE, string $voiceFallbackUrl = Values::NONE, string $voiceFallbackMethod = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE, bool $voiceCallerIdLookup = Values::NONE, string $smsUrl = Values::NONE, string $smsMethod = Values::NONE, string $smsFallbackUrl = Values::NONE, string $smsFallbackMethod = Values::NONE, string $smsStatusCallback = Values::NONE, string $messageStatusCallback = Values::NONE, string $friendlyName = Values::NONE)
    {
        $this->options['apiVersion'] = $apiVersion;
        $this->options['voiceUrl'] = $voiceUrl;
        $this->options['voiceMethod'] = $voiceMethod;
        $this->options['voiceFallbackUrl'] = $voiceFallbackUrl;
        $this->options['voiceFallbackMethod'] = $voiceFallbackMethod;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        $this->options['voiceCallerIdLookup'] = $voiceCallerIdLookup;
        $this->options['smsUrl'] = $smsUrl;
        $this->options['smsMethod'] = $smsMethod;
        $this->options['smsFallbackUrl'] = $smsFallbackUrl;
        $this->options['smsFallbackMethod'] = $smsFallbackMethod;
        $this->options['smsStatusCallback'] = $smsStatusCallback;
        $this->options['messageStatusCallback'] = $messageStatusCallback;
        $this->options['friendlyName'] = $friendlyName;
    }

    public function setApiVersion(string $apiVersion): self
    {
        $this->options['apiVersion'] = $apiVersion;
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

    public function setVoiceCallerIdLookup(bool $voiceCallerIdLookup): self
    {
        $this->options['voiceCallerIdLookup'] = $voiceCallerIdLookup;
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

    public function setSmsStatusCallback(string $smsStatusCallback): self
    {
        $this->options['smsStatusCallback'] = $smsStatusCallback;
        return $this;
    }

    public function setMessageStatusCallback(string $messageStatusCallback): self
    {
        $this->options['messageStatusCallback'] = $messageStatusCallback;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.CreateApplicationOptions ' . $options . ']';
    }
}

class ReadApplicationOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.ReadApplicationOptions ' . $options . ']';
    }
}

class UpdateApplicationOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $apiVersion = Values::NONE, string $voiceUrl = Values::NONE, string $voiceMethod = Values::NONE, string $voiceFallbackUrl = Values::NONE, string $voiceFallbackMethod = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE, bool $voiceCallerIdLookup = Values::NONE, string $smsUrl = Values::NONE, string $smsMethod = Values::NONE, string $smsFallbackUrl = Values::NONE, string $smsFallbackMethod = Values::NONE, string $smsStatusCallback = Values::NONE, string $messageStatusCallback = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['apiVersion'] = $apiVersion;
        $this->options['voiceUrl'] = $voiceUrl;
        $this->options['voiceMethod'] = $voiceMethod;
        $this->options['voiceFallbackUrl'] = $voiceFallbackUrl;
        $this->options['voiceFallbackMethod'] = $voiceFallbackMethod;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        $this->options['voiceCallerIdLookup'] = $voiceCallerIdLookup;
        $this->options['smsUrl'] = $smsUrl;
        $this->options['smsMethod'] = $smsMethod;
        $this->options['smsFallbackUrl'] = $smsFallbackUrl;
        $this->options['smsFallbackMethod'] = $smsFallbackMethod;
        $this->options['smsStatusCallback'] = $smsStatusCallback;
        $this->options['messageStatusCallback'] = $messageStatusCallback;
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

    public function setVoiceCallerIdLookup(bool $voiceCallerIdLookup): self
    {
        $this->options['voiceCallerIdLookup'] = $voiceCallerIdLookup;
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

    public function setSmsStatusCallback(string $smsStatusCallback): self
    {
        $this->options['smsStatusCallback'] = $smsStatusCallback;
        return $this;
    }

    public function setMessageStatusCallback(string $messageStatusCallback): self
    {
        $this->options['messageStatusCallback'] = $messageStatusCallback;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.UpdateApplicationOptions ' . $options . ']';
    }
}