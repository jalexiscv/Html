<?php

namespace Twilio\Rest\Api\V2010\Account\Call;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class RecordingOptions
{
    public static function create(array $recordingStatusCallbackEvent = Values::ARRAY_NONE, string $recordingStatusCallback = Values::NONE, string $recordingStatusCallbackMethod = Values::NONE, string $trim = Values::NONE, string $recordingChannels = Values::NONE, string $recordingTrack = Values::NONE): CreateRecordingOptions
    {
        return new CreateRecordingOptions($recordingStatusCallbackEvent, $recordingStatusCallback, $recordingStatusCallbackMethod, $trim, $recordingChannels, $recordingTrack);
    }

    public static function update(string $pauseBehavior = Values::NONE): UpdateRecordingOptions
    {
        return new UpdateRecordingOptions($pauseBehavior);
    }

    public static function read(string $dateCreatedBefore = Values::NONE, string $dateCreated = Values::NONE, string $dateCreatedAfter = Values::NONE): ReadRecordingOptions
    {
        return new ReadRecordingOptions($dateCreatedBefore, $dateCreated, $dateCreatedAfter);
    }
}

class CreateRecordingOptions extends Options
{
    public function __construct(array $recordingStatusCallbackEvent = Values::ARRAY_NONE, string $recordingStatusCallback = Values::NONE, string $recordingStatusCallbackMethod = Values::NONE, string $trim = Values::NONE, string $recordingChannels = Values::NONE, string $recordingTrack = Values::NONE)
    {
        $this->options['recordingStatusCallbackEvent'] = $recordingStatusCallbackEvent;
        $this->options['recordingStatusCallback'] = $recordingStatusCallback;
        $this->options['recordingStatusCallbackMethod'] = $recordingStatusCallbackMethod;
        $this->options['trim'] = $trim;
        $this->options['recordingChannels'] = $recordingChannels;
        $this->options['recordingTrack'] = $recordingTrack;
    }

    public function setRecordingStatusCallbackEvent(array $recordingStatusCallbackEvent): self
    {
        $this->options['recordingStatusCallbackEvent'] = $recordingStatusCallbackEvent;
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

    public function setTrim(string $trim): self
    {
        $this->options['trim'] = $trim;
        return $this;
    }

    public function setRecordingChannels(string $recordingChannels): self
    {
        $this->options['recordingChannels'] = $recordingChannels;
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
        return '[Twilio.Api.V2010.CreateRecordingOptions ' . $options . ']';
    }
}

class UpdateRecordingOptions extends Options
{
    public function __construct(string $pauseBehavior = Values::NONE)
    {
        $this->options['pauseBehavior'] = $pauseBehavior;
    }

    public function setPauseBehavior(string $pauseBehavior): self
    {
        $this->options['pauseBehavior'] = $pauseBehavior;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.UpdateRecordingOptions ' . $options . ']';
    }
}

class ReadRecordingOptions extends Options
{
    public function __construct(string $dateCreatedBefore = Values::NONE, string $dateCreated = Values::NONE, string $dateCreatedAfter = Values::NONE)
    {
        $this->options['dateCreatedBefore'] = $dateCreatedBefore;
        $this->options['dateCreated'] = $dateCreated;
        $this->options['dateCreatedAfter'] = $dateCreatedAfter;
    }

    public function setDateCreatedBefore(string $dateCreatedBefore): self
    {
        $this->options['dateCreatedBefore'] = $dateCreatedBefore;
        return $this;
    }

    public function setDateCreated(string $dateCreated): self
    {
        $this->options['dateCreated'] = $dateCreated;
        return $this;
    }

    public function setDateCreatedAfter(string $dateCreatedAfter): self
    {
        $this->options['dateCreatedAfter'] = $dateCreatedAfter;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.ReadRecordingOptions ' . $options . ']';
    }
}