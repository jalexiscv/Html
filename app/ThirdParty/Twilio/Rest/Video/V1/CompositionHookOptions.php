<?php

namespace Twilio\Rest\Video\V1;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class CompositionHookOptions
{
    public static function read(bool $enabled = Values::NONE, DateTime $dateCreatedAfter = Values::NONE, DateTime $dateCreatedBefore = Values::NONE, string $friendlyName = Values::NONE): ReadCompositionHookOptions
    {
        return new ReadCompositionHookOptions($enabled, $dateCreatedAfter, $dateCreatedBefore, $friendlyName);
    }

    public static function create(bool $enabled = Values::NONE, array $videoLayout = Values::ARRAY_NONE, array $audioSources = Values::ARRAY_NONE, array $audioSourcesExcluded = Values::ARRAY_NONE, string $resolution = Values::NONE, string $format = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE, bool $trim = Values::NONE): CreateCompositionHookOptions
    {
        return new CreateCompositionHookOptions($enabled, $videoLayout, $audioSources, $audioSourcesExcluded, $resolution, $format, $statusCallback, $statusCallbackMethod, $trim);
    }

    public static function update(bool $enabled = Values::NONE, array $videoLayout = Values::ARRAY_NONE, array $audioSources = Values::ARRAY_NONE, array $audioSourcesExcluded = Values::ARRAY_NONE, bool $trim = Values::NONE, string $format = Values::NONE, string $resolution = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE): UpdateCompositionHookOptions
    {
        return new UpdateCompositionHookOptions($enabled, $videoLayout, $audioSources, $audioSourcesExcluded, $trim, $format, $resolution, $statusCallback, $statusCallbackMethod);
    }
}

class ReadCompositionHookOptions extends Options
{
    public function __construct(bool $enabled = Values::NONE, DateTime $dateCreatedAfter = Values::NONE, DateTime $dateCreatedBefore = Values::NONE, string $friendlyName = Values::NONE)
    {
        $this->options['enabled'] = $enabled;
        $this->options['dateCreatedAfter'] = $dateCreatedAfter;
        $this->options['dateCreatedBefore'] = $dateCreatedBefore;
        $this->options['friendlyName'] = $friendlyName;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->options['enabled'] = $enabled;
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

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Video.V1.ReadCompositionHookOptions ' . $options . ']';
    }
}

class CreateCompositionHookOptions extends Options
{
    public function __construct(bool $enabled = Values::NONE, array $videoLayout = Values::ARRAY_NONE, array $audioSources = Values::ARRAY_NONE, array $audioSourcesExcluded = Values::ARRAY_NONE, string $resolution = Values::NONE, string $format = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE, bool $trim = Values::NONE)
    {
        $this->options['enabled'] = $enabled;
        $this->options['videoLayout'] = $videoLayout;
        $this->options['audioSources'] = $audioSources;
        $this->options['audioSourcesExcluded'] = $audioSourcesExcluded;
        $this->options['resolution'] = $resolution;
        $this->options['format'] = $format;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        $this->options['trim'] = $trim;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->options['enabled'] = $enabled;
        return $this;
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
        return '[Twilio.Video.V1.CreateCompositionHookOptions ' . $options . ']';
    }
}

class UpdateCompositionHookOptions extends Options
{
    public function __construct(bool $enabled = Values::NONE, array $videoLayout = Values::ARRAY_NONE, array $audioSources = Values::ARRAY_NONE, array $audioSourcesExcluded = Values::ARRAY_NONE, bool $trim = Values::NONE, string $format = Values::NONE, string $resolution = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE)
    {
        $this->options['enabled'] = $enabled;
        $this->options['videoLayout'] = $videoLayout;
        $this->options['audioSources'] = $audioSources;
        $this->options['audioSourcesExcluded'] = $audioSourcesExcluded;
        $this->options['trim'] = $trim;
        $this->options['format'] = $format;
        $this->options['resolution'] = $resolution;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->options['enabled'] = $enabled;
        return $this;
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

    public function setTrim(bool $trim): self
    {
        $this->options['trim'] = $trim;
        return $this;
    }

    public function setFormat(string $format): self
    {
        $this->options['format'] = $format;
        return $this;
    }

    public function setResolution(string $resolution): self
    {
        $this->options['resolution'] = $resolution;
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

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Video.V1.UpdateCompositionHookOptions ' . $options . ']';
    }
}