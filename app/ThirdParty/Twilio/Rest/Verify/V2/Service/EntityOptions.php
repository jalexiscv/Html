<?php

namespace Twilio\Rest\Verify\V2\Service;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class EntityOptions
{
    public static function create(string $twilioSandboxMode = Values::NONE): CreateEntityOptions
    {
        return new CreateEntityOptions($twilioSandboxMode);
    }

    public static function delete(string $twilioSandboxMode = Values::NONE): DeleteEntityOptions
    {
        return new DeleteEntityOptions($twilioSandboxMode);
    }

    public static function fetch(string $twilioSandboxMode = Values::NONE): FetchEntityOptions
    {
        return new FetchEntityOptions($twilioSandboxMode);
    }

    public static function read(string $twilioSandboxMode = Values::NONE): ReadEntityOptions
    {
        return new ReadEntityOptions($twilioSandboxMode);
    }
}

class CreateEntityOptions extends Options
{
    public function __construct(string $twilioSandboxMode = Values::NONE)
    {
        $this->options['twilioSandboxMode'] = $twilioSandboxMode;
    }

    public function setTwilioSandboxMode(string $twilioSandboxMode): self
    {
        $this->options['twilioSandboxMode'] = $twilioSandboxMode;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Verify.V2.CreateEntityOptions ' . $options . ']';
    }
}

class DeleteEntityOptions extends Options
{
    public function __construct(string $twilioSandboxMode = Values::NONE)
    {
        $this->options['twilioSandboxMode'] = $twilioSandboxMode;
    }

    public function setTwilioSandboxMode(string $twilioSandboxMode): self
    {
        $this->options['twilioSandboxMode'] = $twilioSandboxMode;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Verify.V2.DeleteEntityOptions ' . $options . ']';
    }
}

class FetchEntityOptions extends Options
{
    public function __construct(string $twilioSandboxMode = Values::NONE)
    {
        $this->options['twilioSandboxMode'] = $twilioSandboxMode;
    }

    public function setTwilioSandboxMode(string $twilioSandboxMode): self
    {
        $this->options['twilioSandboxMode'] = $twilioSandboxMode;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Verify.V2.FetchEntityOptions ' . $options . ']';
    }
}

class ReadEntityOptions extends Options
{
    public function __construct(string $twilioSandboxMode = Values::NONE)
    {
        $this->options['twilioSandboxMode'] = $twilioSandboxMode;
    }

    public function setTwilioSandboxMode(string $twilioSandboxMode): self
    {
        $this->options['twilioSandboxMode'] = $twilioSandboxMode;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Verify.V2.ReadEntityOptions ' . $options . ']';
    }
}