<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class PhoneCallOptions
{
    public static function create(string $reason = Values::NONE, string $applicationSid = Values::NONE, string $callerId = Values::NONE, string $fallbackMethod = Values::NONE, string $fallbackUrl = Values::NONE, string $machineDetection = Values::NONE, int $machineDetectionSilenceTimeout = Values::NONE, int $machineDetectionSpeechEndThreshold = Values::NONE, int $machineDetectionSpeechThreshold = Values::NONE, int $machineDetectionTimeout = Values::NONE, string $method = Values::NONE, bool $record = Values::NONE, string $recordingChannels = Values::NONE, string $recordingStatusCallback = Values::NONE, array $recordingStatusCallbackEvent = Values::ARRAY_NONE, string $recordingStatusCallbackMethod = Values::NONE, string $sendDigits = Values::NONE, string $sipAuthPassword = Values::NONE, string $sipAuthUsername = Values::NONE, string $statusCallback = Values::NONE, array $statusCallbackEvent = Values::ARRAY_NONE, string $statusCallbackMethod = Values::NONE, int $timeout = Values::NONE, string $trim = Values::NONE, string $url = Values::NONE): CreatePhoneCallOptions
    {
        return new CreatePhoneCallOptions($reason, $applicationSid, $callerId, $fallbackMethod, $fallbackUrl, $machineDetection, $machineDetectionSilenceTimeout, $machineDetectionSpeechEndThreshold, $machineDetectionSpeechThreshold, $machineDetectionTimeout, $method, $record, $recordingChannels, $recordingStatusCallback, $recordingStatusCallbackEvent, $recordingStatusCallbackMethod, $sendDigits, $sipAuthPassword, $sipAuthUsername, $statusCallback, $statusCallbackEvent, $statusCallbackMethod, $timeout, $trim, $url);
    }
}

class CreatePhoneCallOptions extends Options
{
    public function __construct(string $reason = Values::NONE, string $applicationSid = Values::NONE, string $callerId = Values::NONE, string $fallbackMethod = Values::NONE, string $fallbackUrl = Values::NONE, string $machineDetection = Values::NONE, int $machineDetectionSilenceTimeout = Values::NONE, int $machineDetectionSpeechEndThreshold = Values::NONE, int $machineDetectionSpeechThreshold = Values::NONE, int $machineDetectionTimeout = Values::NONE, string $method = Values::NONE, bool $record = Values::NONE, string $recordingChannels = Values::NONE, string $recordingStatusCallback = Values::NONE, array $recordingStatusCallbackEvent = Values::ARRAY_NONE, string $recordingStatusCallbackMethod = Values::NONE, string $sendDigits = Values::NONE, string $sipAuthPassword = Values::NONE, string $sipAuthUsername = Values::NONE, string $statusCallback = Values::NONE, array $statusCallbackEvent = Values::ARRAY_NONE, string $statusCallbackMethod = Values::NONE, int $timeout = Values::NONE, string $trim = Values::NONE, string $url = Values::NONE)
    {
        $this->options['reason'] = $reason;
        $this->options['applicationSid'] = $applicationSid;
        $this->options['callerId'] = $callerId;
        $this->options['fallbackMethod'] = $fallbackMethod;
        $this->options['fallbackUrl'] = $fallbackUrl;
        $this->options['machineDetection'] = $machineDetection;
        $this->options['machineDetectionSilenceTimeout'] = $machineDetectionSilenceTimeout;
        $this->options['machineDetectionSpeechEndThreshold'] = $machineDetectionSpeechEndThreshold;
        $this->options['machineDetectionSpeechThreshold'] = $machineDetectionSpeechThreshold;
        $this->options['machineDetectionTimeout'] = $machineDetectionTimeout;
        $this->options['method'] = $method;
        $this->options['record'] = $record;
        $this->options['recordingChannels'] = $recordingChannels;
        $this->options['recordingStatusCallback'] = $recordingStatusCallback;
        $this->options['recordingStatusCallbackEvent'] = $recordingStatusCallbackEvent;
        $this->options['recordingStatusCallbackMethod'] = $recordingStatusCallbackMethod;
        $this->options['sendDigits'] = $sendDigits;
        $this->options['sipAuthPassword'] = $sipAuthPassword;
        $this->options['sipAuthUsername'] = $sipAuthUsername;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['statusCallbackEvent'] = $statusCallbackEvent;
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        $this->options['timeout'] = $timeout;
        $this->options['trim'] = $trim;
        $this->options['url'] = $url;
    }

    public function setReason(string $reason): self
    {
        $this->options['reason'] = $reason;
        return $this;
    }

    public function setApplicationSid(string $applicationSid): self
    {
        $this->options['applicationSid'] = $applicationSid;
        return $this;
    }

    public function setCallerId(string $callerId): self
    {
        $this->options['callerId'] = $callerId;
        return $this;
    }

    public function setFallbackMethod(string $fallbackMethod): self
    {
        $this->options['fallbackMethod'] = $fallbackMethod;
        return $this;
    }

    public function setFallbackUrl(string $fallbackUrl): self
    {
        $this->options['fallbackUrl'] = $fallbackUrl;
        return $this;
    }

    public function setMachineDetection(string $machineDetection): self
    {
        $this->options['machineDetection'] = $machineDetection;
        return $this;
    }

    public function setMachineDetectionSilenceTimeout(int $machineDetectionSilenceTimeout): self
    {
        $this->options['machineDetectionSilenceTimeout'] = $machineDetectionSilenceTimeout;
        return $this;
    }

    public function setMachineDetectionSpeechEndThreshold(int $machineDetectionSpeechEndThreshold): self
    {
        $this->options['machineDetectionSpeechEndThreshold'] = $machineDetectionSpeechEndThreshold;
        return $this;
    }

    public function setMachineDetectionSpeechThreshold(int $machineDetectionSpeechThreshold): self
    {
        $this->options['machineDetectionSpeechThreshold'] = $machineDetectionSpeechThreshold;
        return $this;
    }

    public function setMachineDetectionTimeout(int $machineDetectionTimeout): self
    {
        $this->options['machineDetectionTimeout'] = $machineDetectionTimeout;
        return $this;
    }

    public function setMethod(string $method): self
    {
        $this->options['method'] = $method;
        return $this;
    }

    public function setRecord(bool $record): self
    {
        $this->options['record'] = $record;
        return $this;
    }

    public function setRecordingChannels(string $recordingChannels): self
    {
        $this->options['recordingChannels'] = $recordingChannels;
        return $this;
    }

    public function setRecordingStatusCallback(string $recordingStatusCallback): self
    {
        $this->options['recordingStatusCallback'] = $recordingStatusCallback;
        return $this;
    }

    public function setRecordingStatusCallbackEvent(array $recordingStatusCallbackEvent): self
    {
        $this->options['recordingStatusCallbackEvent'] = $recordingStatusCallbackEvent;
        return $this;
    }

    public function setRecordingStatusCallbackMethod(string $recordingStatusCallbackMethod): self
    {
        $this->options['recordingStatusCallbackMethod'] = $recordingStatusCallbackMethod;
        return $this;
    }

    public function setSendDigits(string $sendDigits): self
    {
        $this->options['sendDigits'] = $sendDigits;
        return $this;
    }

    public function setSipAuthPassword(string $sipAuthPassword): self
    {
        $this->options['sipAuthPassword'] = $sipAuthPassword;
        return $this;
    }

    public function setSipAuthUsername(string $sipAuthUsername): self
    {
        $this->options['sipAuthUsername'] = $sipAuthUsername;
        return $this;
    }

    public function setStatusCallback(string $statusCallback): self
    {
        $this->options['statusCallback'] = $statusCallback;
        return $this;
    }

    public function setStatusCallbackEvent(array $statusCallbackEvent): self
    {
        $this->options['statusCallbackEvent'] = $statusCallbackEvent;
        return $this;
    }

    public function setStatusCallbackMethod(string $statusCallbackMethod): self
    {
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        return $this;
    }

    public function setTimeout(int $timeout): self
    {
        $this->options['timeout'] = $timeout;
        return $this;
    }

    public function setTrim(string $trim): self
    {
        $this->options['trim'] = $trim;
        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->options['url'] = $url;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.TrustedComms.CreatePhoneCallOptions ' . $options . ']';
    }
}