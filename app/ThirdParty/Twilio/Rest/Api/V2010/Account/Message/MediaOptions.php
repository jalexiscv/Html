<?php

namespace Twilio\Rest\Api\V2010\Account\Message;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class MediaOptions
{
    public static function read(string $dateCreatedBefore = Values::NONE, string $dateCreated = Values::NONE, string $dateCreatedAfter = Values::NONE): ReadMediaOptions
    {
        return new ReadMediaOptions($dateCreatedBefore, $dateCreated, $dateCreatedAfter);
    }
}

class ReadMediaOptions extends Options
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
        return '[Twilio.Api.V2010.ReadMediaOptions ' . $options . ']';
    }
}