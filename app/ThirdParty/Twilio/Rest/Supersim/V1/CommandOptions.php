<?php

namespace Twilio\Rest\Supersim\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class CommandOptions
{
    public static function create(string $callbackMethod = Values::NONE, string $callbackUrl = Values::NONE): CreateCommandOptions
    {
        return new CreateCommandOptions($callbackMethod, $callbackUrl);
    }

    public static function read(string $sim = Values::NONE, string $status = Values::NONE, string $direction = Values::NONE): ReadCommandOptions
    {
        return new ReadCommandOptions($sim, $status, $direction);
    }
}

class CreateCommandOptions extends Options
{
    public function __construct(string $callbackMethod = Values::NONE, string $callbackUrl = Values::NONE)
    {
        $this->options['callbackMethod'] = $callbackMethod;
        $this->options['callbackUrl'] = $callbackUrl;
    }

    public function setCallbackMethod(string $callbackMethod): self
    {
        $this->options['callbackMethod'] = $callbackMethod;
        return $this;
    }

    public function setCallbackUrl(string $callbackUrl): self
    {
        $this->options['callbackUrl'] = $callbackUrl;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Supersim.V1.CreateCommandOptions ' . $options . ']';
    }
}

class ReadCommandOptions extends Options
{
    public function __construct(string $sim = Values::NONE, string $status = Values::NONE, string $direction = Values::NONE)
    {
        $this->options['sim'] = $sim;
        $this->options['status'] = $status;
        $this->options['direction'] = $direction;
    }

    public function setSim(string $sim): self
    {
        $this->options['sim'] = $sim;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setDirection(string $direction): self
    {
        $this->options['direction'] = $direction;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Supersim.V1.ReadCommandOptions ' . $options . ']';
    }
}