<?php

namespace Twilio\Rest\Preview\Understand\Assistant;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ModelBuildOptions
{
    public static function create(string $statusCallback = Values::NONE, string $uniqueName = Values::NONE): CreateModelBuildOptions
    {
        return new CreateModelBuildOptions($statusCallback, $uniqueName);
    }

    public static function update(string $uniqueName = Values::NONE): UpdateModelBuildOptions
    {
        return new UpdateModelBuildOptions($uniqueName);
    }
}

class CreateModelBuildOptions extends Options
{
    public function __construct(string $statusCallback = Values::NONE, string $uniqueName = Values::NONE)
    {
        $this->options['statusCallback'] = $statusCallback;
        $this->options['uniqueName'] = $uniqueName;
    }

    public function setStatusCallback(string $statusCallback): self
    {
        $this->options['statusCallback'] = $statusCallback;
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
        return '[Twilio.Preview.Understand.CreateModelBuildOptions ' . $options . ']';
    }
}

class UpdateModelBuildOptions extends Options
{
    public function __construct(string $uniqueName = Values::NONE)
    {
        $this->options['uniqueName'] = $uniqueName;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Understand.UpdateModelBuildOptions ' . $options . ']';
    }
}