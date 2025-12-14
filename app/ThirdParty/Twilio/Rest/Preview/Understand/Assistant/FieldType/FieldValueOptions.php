<?php

namespace Twilio\Rest\Preview\Understand\Assistant\FieldType;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class FieldValueOptions
{
    public static function read(string $language = Values::NONE): ReadFieldValueOptions
    {
        return new ReadFieldValueOptions($language);
    }

    public static function create(string $synonymOf = Values::NONE): CreateFieldValueOptions
    {
        return new CreateFieldValueOptions($synonymOf);
    }
}

class ReadFieldValueOptions extends Options
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
        return '[Twilio.Preview.Understand.ReadFieldValueOptions ' . $options . ']';
    }
}

class CreateFieldValueOptions extends Options
{
    public function __construct(string $synonymOf = Values::NONE)
    {
        $this->options['synonymOf'] = $synonymOf;
    }

    public function setSynonymOf(string $synonymOf): self
    {
        $this->options['synonymOf'] = $synonymOf;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Understand.CreateFieldValueOptions ' . $options . ']';
    }
}