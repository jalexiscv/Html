<?php

namespace Twilio\Rest\Studio\V1\Flow;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ExecutionOptions
{
    public static function read(DateTime $dateCreatedFrom = Values::NONE, DateTime $dateCreatedTo = Values::NONE): ReadExecutionOptions
    {
        return new ReadExecutionOptions($dateCreatedFrom, $dateCreatedTo);
    }

    public static function create(array $parameters = Values::ARRAY_NONE): CreateExecutionOptions
    {
        return new CreateExecutionOptions($parameters);
    }
}

class ReadExecutionOptions extends Options
{
    public function __construct(DateTime $dateCreatedFrom = Values::NONE, DateTime $dateCreatedTo = Values::NONE)
    {
        $this->options['dateCreatedFrom'] = $dateCreatedFrom;
        $this->options['dateCreatedTo'] = $dateCreatedTo;
    }

    public function setDateCreatedFrom(DateTime $dateCreatedFrom): self
    {
        $this->options['dateCreatedFrom'] = $dateCreatedFrom;
        return $this;
    }

    public function setDateCreatedTo(DateTime $dateCreatedTo): self
    {
        $this->options['dateCreatedTo'] = $dateCreatedTo;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Studio.V1.ReadExecutionOptions ' . $options . ']';
    }
}

class CreateExecutionOptions extends Options
{
    public function __construct(array $parameters = Values::ARRAY_NONE)
    {
        $this->options['parameters'] = $parameters;
    }

    public function setParameters(array $parameters): self
    {
        $this->options['parameters'] = $parameters;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Studio.V1.CreateExecutionOptions ' . $options . ']';
    }
}