<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class CallOptions
{
    public static function create(string $url = Values::NONE, string $twiml = Values::NONE, string $applicationSid = Values::NONE, string $method = Values::NONE, string $fallbackUrl = Values::NONE, string $fallbackMethod = Values::NONE, string $statusCallback = Values::NONE, array $statusCallbackEvent = Values::ARRAY_NONE, string $statusCallbackMethod = Values::NONE, string $sendDigits = Values::NONE, int $timeout = Values::NONE, bool $record = Values::NONE, string $recordingChannels = Values::NONE, string $recordingStatusCallback = Values::NONE, string $recordingStatusCallbackMethod = Values::NONE, string $sipAuthUsername = Values::NONE, string $sipAuthPassword = Values::NONE, string $machineDetection = Values::NONE, int $machineDetectionTimeout = Values::NONE, array $recordingStatusCallbackEvent = Values::ARRAY_NONE, string $trim = Values::NONE, string $callerId = Values::NONE, int $machineDetectionSpeechThreshold = Values::NONE, int $machineDetectionSpeechEndThreshold = Values::NONE, int $machineDetectionSilenceTimeout = Values::NONE, string $asyncAmd = Values::NONE, string $asyncAmdStatusCallback = Values::NONE, string $asyncAmdStatusCallbackMethod = Values::NONE, string $byoc = Values::NONE, string $callReason = Values::NONE, string $recordingTrack = Values::NONE): CreateCallOptions
    {
        return new CreateCallOptions($url, $twiml, $applicationSid, $method, $fallbackUrl, $fallbackMethod, $statusCallback, $statusCallbackEvent, $statusCallbackMethod, $sendDigits, $timeout, $record, $recordingChannels, $recordingStatusCallback, $recordingStatusCallbackMethod, $sipAuthUsername, $sipAuthPassword, $machineDetection, $machineDetectionTimeout, $recordingStatusCallbackEvent, $trim, $callerId, $machineDetectionSpeechThreshold, $machineDetectionSpeechEndThreshold, $machineDetectionSilenceTimeout, $asyncAmd, $asyncAmdStatusCallback, $asyncAmdStatusCallbackMethod, $byoc, $callReason, $recordingTrack);
    }

    public static function read(string $to = Values::NONE, string $from = Values::NONE, string $parentCallSid = Values::NONE, string $status = Values::NONE, string $startTimeBefore = Values::NONE, string $startTime = Values::NONE, string $startTimeAfter = Values::NONE, string $endTimeBefore = Values::NONE, string $endTime = Values::NONE, string $endTimeAfter = Values::NONE): ReadCallOptions
    {
        return new ReadCallOptions($to, $from, $parentCallSid, $status, $startTimeBefore, $startTime, $startTimeAfter, $endTimeBefore, $endTime, $endTimeAfter);
    }

    public static function update(string $url = Values::NONE, string $method = Values::NONE, string $status = Values::NONE, string $fallbackUrl = Values::NONE, string $fallbackMethod = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE, string $twiml = Values::NONE): UpdateCallOptions
    {
        return new UpdateCallOptions($url, $method, $status, $fallbackUrl, $fallbackMethod, $statusCallback, $statusCallbackMethod, $twiml);
    }
}

class CreateCallOptions extends Options
{
    public function __construct(string $url = Values::NONE, string $twiml = Values::NONE, string $applicationSid = Values::NONE, string $method = Values::NONE, string $fallbackUrl = Values::NONE, string $fallbackMethod = Values::NONE, string $statusCallback = Values::NONE, array $statusCallbackEvent = Values::ARRAY_NONE, string $statusCallbackMethod = Values::NONE, string $sendDigits = Values::NONE, int $timeout = Values::NONE, bool $record = Values::NONE, string $recordingChannels = Values::NONE, string $recordingStatusCallback = Values::NONE, string $recordingStatusCallbackMethod = Values::NONE, string $sipAuthUsername = Values::NONE, string $sipAuthPassword = Values::NONE, string $machineDetection = Values::NONE, int $machineDetectionTimeout = Values::NONE, array $recordingStatusCallbackEvent = Values::ARRAY_NONE, string $trim = Values::NONE, string $callerId = Values::NONE, int $machineDetectionSpeechThreshold = Values::NONE, int $machineDetectionSpeechEndThreshold = Values::NONE, int $machineDetectionSilenceTimeout = Values::NONE, string $asyncAmd = Values::NONE, string $asyncAmdStatusCallback = Values::NONE, string $asyncAmdStatusCallbackMethod = Values::NONE, string $byoc = Values::NONE, string $callReason = Values::NONE, string $recordingTrack = Values::NONE)
    {
        $this->options['url'] = $url;
        $this->options['twiml'] = $twiml;
        $this->options['applicationSid'] = $applicationSid;
        $this->options['method'] = $method;
        $this->options['fallbackUrl'] = $fallbackUrl;
        $this->options['fallbackMethod'] = $fallbackMethod;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['statusCallbackEvent'] = $statusCallbackEvent;
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        $this->options['sendDigits'] = $sendDigits;
        $this->options['timeout'] = $timeout;
        $this->options['record'] = $record;
        $this->options['recordingChannels'] = $recordingChannels;
        $this->options['recordingStatusCallback'] = $recordingStatusCallback;
        $this->options['recordingStatusCallbackMethod'] = $recordingStatusCallbackMethod;
        $this->options['sipAuthUsername'] = $sipAuthUsername;
        $this->options['sipAuthPassword'] = $sipAuthPassword;
        $this->options['machineDetection'] = $machineDetection;
        $this->options['machineDetectionTimeout'] = $machineDetectionTimeout;
        $this->options['recordingStatusCallbackEvent'] = $recordingStatusCallbackEvent;
        $this->options['trim'] = $trim;
        $this->options['callerId'] = $callerId;
        $this->options['machineDetectionSpeechThreshold'] = $machineDetectionSpeechThreshold;
        $this->options['machineDetectionSpeechEndThreshold'] = $machineDetectionSpeechEndThreshold;
        $this->options['machineDetectionSilenceTimeout'] = $machineDetectionSilenceTimeout;
        $this->options['asyncAmd'] = $asyncAmd;
        $this->options['asyncAmdStatusCallback'] = $asyncAmdStatusCallback;
        $this->options['asyncAmdStatusCallbackMethod'] = $asyncAmdStatusCallbackMethod;
        $this->options['byoc'] = $byoc;
        $this->options['callReason'] = $callReason;
        $this->options['recordingTrack'] = $recordingTrack;
    }

    public function setUrl(string $url): self
    {
        $this->options['url'] = $url;
        return $this;
    }

    public function setTwiml(string $twiml): self
    {
        $this->options['twiml'] = $twiml;
        return $this;
    }

    public function setApplicationSid(string $applicationSid): self
    {
        $this->options['applicationSid'] = $applicationSid;
        return $this;
    }

    public function setMethod(string $method): self
    {
        $this->options['method'] = $method;
        return $this;
    }

    public function setFallbackUrl(string $fallbackUrl): self
    {
        $this->options['fallbackUrl'] = $fallbackUrl;
        return $this;
    }

    public function setFallbackMethod(string $fallbackMethod): self
    {
        $this->options['fallbackMethod'] = $fallbackMethod;
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

    public function setSendDigits(string $sendDigits): self
    {
        $this->options['sendDigits'] = $sendDigits;
        return $this;
    }

    public function setTimeout(int $timeout): self
    {
        $this->options['timeout'] = $timeout;
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

    public function setRecordingStatusCallbackMethod(string $recordingStatusCallbackMethod): self
    {
        $this->options['recordingStatusCallbackMethod'] = $recordingStatusCallbackMethod;
        return $this;
    }

    public function setSipAuthUsername(string $sipAuthUsername): self
    {
        $this->options['sipAuthUsername'] = $sipAuthUsername;
        return $this;
    }

    public function setSipAuthPassword(string $sipAuthPassword): self
    {
        $this->options['sipAuthPassword'] = $sipAuthPassword;
        return $this;
    }

    public function setMachineDetection(string $machineDetection): self
    {
        $this->options['machineDetection'] = $machineDetection;
        return $this;
    }

    public function setMachineDetectionTimeout(int $machineDetectionTimeout): self
    {
        $this->options['machineDetectionTimeout'] = $machineDetectionTimeout;
        return $this;
    }

    public function setRecordingStatusCallbackEvent(array $recordingStatusCallbackEvent): self
    {
        $this->options['recordingStatusCallbackEvent'] = $recordingStatusCallbackEvent;
        return $this;
    }

    public function setTrim(string $trim): self
    {
        $this->options['trim'] = $trim;
        return $this;
    }

    public function setCallerId(string $callerId): self
    {
        $this->options['callerId'] = $callerId;
        return $this;
    }

    public function setMachineDetectionSpeechThreshold(int $machineDetectionSpeechThreshold): self
    {
        $this->options['machineDetectionSpeechThreshold'] = $machineDetectionSpeechThreshold;
        return $this;
    }

    public function setMachineDetectionSpeechEndThreshold(int $machineDetectionSpeechEndThreshold): self
    {
        $this->options['machineDetectionSpeechEndThreshold'] = $machineDetectionSpeechEndThreshold;
        return $this;
    }

    public function setMachineDetectionSilenceTimeout(int $machineDetectionSilenceTimeout): self
    {
        $this->options['machineDetectionSilenceTimeout'] = $machineDetectionSilenceTimeout;
        return $this;
    }

    public function setAsyncAmd(string $asyncAmd): self
    {
        $this->options['asyncAmd'] = $asyncAmd;
        return $this;
    }

    public function setAsyncAmdStatusCallback(string $asyncAmdStatusCallback): self
    {
        $this->options['asyncAmdStatusCallback'] = $asyncAmdStatusCallback;
        return $this;
    }

    public function setAsyncAmdStatusCallbackMethod(string $asyncAmdStatusCallbackMethod): self
    {
        $this->options['asyncAmdStatusCallbackMethod'] = $asyncAmdStatusCallbackMethod;
        return $this;
    }

    public function setByoc(string $byoc): self
    {
        $this->options['byoc'] = $byoc;
        return $this;
    }

    public function setCallReason(string $callReason): self
    {
        $this->options['callReason'] = $callReason;
        return $this;
    }

    public function setRecordingTrack(string $recordingTrack): self
    {
        $this->options['recordingTrack'] = $recordingTrack;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.CreateCallOptions ' . $options . ']';
    }
}

class ReadCallOptions extends Options
{
    public function __construct(string $to = Values::NONE, string $from = Values::NONE, string $parentCallSid = Values::NONE, string $status = Values::NONE, string $startTimeBefore = Values::NONE, string $startTime = Values::NONE, string $startTimeAfter = Values::NONE, string $endTimeBefore = Values::NONE, string $endTime = Values::NONE, string $endTimeAfter = Values::NONE)
    {
        $this->options['to'] = $to;
        $this->options['from'] = $from;
        $this->options['parentCallSid'] = $parentCallSid;
        $this->options['status'] = $status;
        $this->options['startTimeBefore'] = $startTimeBefore;
        $this->options['startTime'] = $startTime;
        $this->options['startTimeAfter'] = $startTimeAfter;
        $this->options['endTimeBefore'] = $endTimeBefore;
        $this->options['endTime'] = $endTime;
        $this->options['endTimeAfter'] = $endTimeAfter;
    }

    public function setTo(string $to): self
    {
        $this->options['to'] = $to;
        return $this;
    }

    public function setFrom(string $from): self
    {
        $this->options['from'] = $from;
        return $this;
    }

    public function setParentCallSid(string $parentCallSid): self
    {
        $this->options['parentCallSid'] = $parentCallSid;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setStartTimeBefore(string $startTimeBefore): self
    {
        $this->options['startTimeBefore'] = $startTimeBefore;
        return $this;
    }

    public function setStartTime(string $startTime): self
    {
        $this->options['startTime'] = $startTime;
        return $this;
    }

    public function setStartTimeAfter(string $startTimeAfter): self
    {
        $this->options['startTimeAfter'] = $startTimeAfter;
        return $this;
    }

    public function setEndTimeBefore(string $endTimeBefore): self
    {
        $this->options['endTimeBefore'] = $endTimeBefore;
        return $this;
    }

    public function setEndTime(string $endTime): self
    {
        $this->options['endTime'] = $endTime;
        return $this;
    }

    public function setEndTimeAfter(string $endTimeAfter): self
    {
        $this->options['endTimeAfter'] = $endTimeAfter;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.ReadCallOptions ' . $options . ']';
    }
}

class UpdateCallOptions extends Options
{
    public function __construct(string $url = Values::NONE, string $method = Values::NONE, string $status = Values::NONE, string $fallbackUrl = Values::NONE, string $fallbackMethod = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE, string $twiml = Values::NONE)
    {
        $this->options['url'] = $url;
        $this->options['method'] = $method;
        $this->options['status'] = $status;
        $this->options['fallbackUrl'] = $fallbackUrl;
        $this->options['fallbackMethod'] = $fallbackMethod;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        $this->options['twiml'] = $twiml;
    }

    public function setUrl(string $url): self
    {
        $this->options['url'] = $url;
        return $this;
    }

    public function setMethod(string $method): self
    {
        $this->options['method'] = $method;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setFallbackUrl(string $fallbackUrl): self
    {
        $this->options['fallbackUrl'] = $fallbackUrl;
        return $this;
    }

    public function setFallbackMethod(string $fallbackMethod): self
    {
        $this->options['fallbackMethod'] = $fallbackMethod;
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

    public function setTwiml(string $twiml): self
    {
        $this->options['twiml'] = $twiml;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.UpdateCallOptions ' . $options . ']';
    }
}