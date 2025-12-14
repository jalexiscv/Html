<?php

namespace Twilio\Rest\Verify\V2\Service;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class RateLimitOptions
{
    public static function create(string $description = Values::NONE): CreateRateLimitOptions
    {
        return new CreateRateLimitOptions($description);
    }

    public static function update(string $description = Values::NONE): UpdateRateLimitOptions
    {
        return new UpdateRateLimitOptions($description);
    }
}

class CreateRateLimitOptions extends Options
{
    public function __construct(string $description = Values::NONE)
    {
        $this->options['description'] = $description;
    }

    public function setDescription(string $description): self
    {
        $this->options['description'] = $description;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Verify.V2.CreateRateLimitOptions ' . $options . ']';
    }
}

class UpdateRateLimitOptions extends Options
{
    public function __construct(string $description = Values::NONE)
    {
        $this->options['description'] = $description;
    }

    public function setDescription(string $description): self
    {
        $this->options['description'] = $description;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Verify.V2.UpdateRateLimitOptions ' . $options . ']';
    }
}