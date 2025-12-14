<?php

namespace Twilio\Rest\Autopilot\V1\Assistant\Task;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class SampleOptions
{
    public static function read(string $language = Values::NONE): ReadSampleOptions
    {
        return new ReadSampleOptions($language);
    }

    public static function create(string $sourceChannel = Values::NONE): CreateSampleOptions
    {
        return new CreateSampleOptions($sourceChannel);
    }

    public static function update(string $language = Values::NONE, string $taggedText = Values::NONE, string $sourceChannel = Values::NONE): UpdateSampleOptions
    {
        return new UpdateSampleOptions($language, $taggedText, $sourceChannel);
    }
}

class ReadSampleOptions extends Options
{
    public function __construct(string $language = Values::NONE)
    {
        $this->options['language'] = $language;
    }

    public function setLanguage(string $language): self
    {
        $this->options['language'] = $language;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Autopilot.V1.ReadSampleOptions ' . $options . ']';
    }
}

class CreateSampleOptions extends Options
{
    public function __construct(string $sourceChannel = Values::NONE)
    {
        $this->options['sourceChannel'] = $sourceChannel;
    }

    public function setSourceChannel(string $sourceChannel): self
    {
        $this->options['sourceChannel'] = $sourceChannel;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Autopilot.V1.CreateSampleOptions ' . $options . ']';
    }
}

class UpdateSampleOptions extends Options
{
    public function __construct(string $language = Values::NONE, string $taggedText = Values::NONE, string $sourceChannel = Values::NONE)
    {
        $this->options['language'] = $language;
        $this->options['taggedText'] = $taggedText;
        $this->options['sourceChannel'] = $sourceChannel;
    }

    public function setLanguage(string $language): self
    {
        $this->options['language'] = $language;
        return $this;
    }

    public function setTaggedText(string $taggedText): self
    {
        $this->options['taggedText'] = $taggedText;
        return $this;
    }

    public function setSourceChannel(string $sourceChannel): self
    {
        $this->options['sourceChannel'] = $sourceChannel;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Autopilot.V1.UpdateSampleOptions ' . $options . ']';
    }
}