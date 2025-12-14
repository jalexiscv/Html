<?php

namespace Twilio\Rest\Preview\Understand\Assistant;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class FieldTypeOptions
{
    public static function create(string $friendlyName = Values::NONE): CreateFieldTypeOptions
    {
        return new CreateFieldTypeOptions($friendlyName);
    }

    public static function update(string $friendlyName = Values::NONE, string $uniqueName = Values::NONE): UpdateFieldTypeOptions
    {
        return new UpdateFieldTypeOptions($friendlyName, $uniqueName);
    }
}

class CreateFieldTypeOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Understand.CreateFieldTypeOptions ' . $options . ']';
    }
}

class UpdateFieldTypeOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $uniqueName = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['uniqueName'] = $uniqueName;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Understand.UpdateFieldTypeOptions ' . $options . ']';
    }
}