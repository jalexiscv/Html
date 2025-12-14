<?php

namespace Twilio\Rest\Api\V2010\Account\Conference;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class RecordingOptions
{
    public static function update(string $pauseBehavior = Values::NONE): UpdateRecordingOptions
    {
        return new UpdateRecordingOptions($pauseBehavior);
    }

    public static function read(string $dateCreatedBefore = Values::NONE, string $dateCreated = Values::NONE, string $dateCreatedAfter = Values::NONE): ReadRecordingOptions
    {
        return new ReadRecordingOptions($dateCreatedBefore, $dateCreated, $dateCreatedAfter);
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