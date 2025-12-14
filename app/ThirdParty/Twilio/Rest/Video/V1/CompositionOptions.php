<?php

namespace Twilio\Rest\Video\V1;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class CompositionOptions
{
    public static function read(string $status = Values::NONE, DateTime $dateCreatedAfter = Values::NONE, DateTime $dateCreatedBefore = Values::NONE, string $roomSid = Values::NONE): ReadCompositionOptions
    {
        return new ReadCompositionOptions($status, $dateCreatedAfter, $dateCreatedBefore, $roomSid);
    }

    public static function create(array $videoLayout = Values::ARRAY_NONE, array $audioSources = Values::ARRAY_NONE, array $audioSourcesExcluded = Values::ARRAY_NONE, string $resolution = Values::NONE, string $format = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE, bool $trim = Values::NONE): CreateCompositionOptions
    {
        return new CreateCompositionOptions($videoLayout, $audioSources, $audioSourcesExcluded, $resolution, $format, $statusCallback, $statusCallbackMethod, $trim);
    }
}

class ReadCompositionOptions extends Options
{
    public function __construct(string $status = Values::NONE, DateTime $dateCreatedAfter = Values::NONE, DateTime $dateCreatedBefore = Values::NONE, string $roomSid = Values::NONE)
    {
        $this->options['status'] = $status;
        $this->options['dateCreatedAfter'] = $dateCreatedAfter;
        $this->options['dateCreatedBefore'] = $dateCreatedBefore;
        $this->options['roomSid'] = $roomSid;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setDateCreatedAfter(DateTime $dateCreatedAfter): self
    {
        $this->options['dateCreatedAfter'] = $dateCreatedAfter;
        return $this;
    }

    public function setDateCreatedBefore(DateTime $dateCreatedBefore): self
    {
        $this->options['dateCreatedBefore'] = $dateCreatedBefore;
        return $this;
    }

    public function setRoomSid(string $roomSid): self
    {
        $this->options['roomSid'] = $roomSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Video.V1.ReadCompositionOptions ' . $options . ']';
    }
}

class CreateCompositionOptions extends Options
{
    public function __construct(array $videoLayout = Values::ARRAY_NONE, array $audioSources = Values::ARRAY_NONE, array $audioSourcesExcluded = Values::ARRAY_NONE, string $resolution = Values::NONE, string $format = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE, bool $trim = Values::NONE)
    {
        $this->options['videoLayout'] = $videoLayout;
        $this->options['audioSources'] = $audioSources;
        $this->options['audioSourcesExcluded'] = $audioSourcesExcluded;
        $this->options['resolution'] = $resolution;
        $this->options['format'] = $format;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        $this->options['trim'] = $trim;
    }

    public function setVideoLayout(array $videoLayout): self
    {
        $this->options['videoLayout'] = $videoLayout;
        return $this;
    }

    public function setAudioSources(array $audioSources): self
    {
        $this->options['audioSources'] = $audioSources;
        return $this;
    }

    public function setAudioSourcesExcluded(array $audioSourcesExcluded): self
    {
        $this->options['audioSourcesExcluded'] = $audioSourcesExcluded;
        return $this;
    }

    public function setResolution(string $resolution): self
    {
        $this->options['resolution'] = $resolution;
        return $this;
    }

    public function setFormat(string $format): self
    {
        $this->options['format'] = $format;
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

    public function setTrim(bool $trim): self
    {
        $this->options['trim'] = $trim;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Video.V1.CreateCompositionOptions ' . $options . ']';
    }
}