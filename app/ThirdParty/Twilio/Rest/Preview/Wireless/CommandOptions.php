<?php

namespace Twilio\Rest\Preview\Wireless;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class CommandOptions
{
    public static function read(string $device = Values::NONE, string $sim = Values::NONE, string $status = Values::NONE, string $direction = Values::NONE): ReadCommandOptions
    {
        return new ReadCommandOptions($device, $sim, $status, $direction);
    }

    public static function create(string $device = Values::NONE, string $sim = Values::NONE, string $callbackMethod = Values::NONE, string $callbackUrl = Values::NONE, string $commandMode = Values::NONE, string $includeSid = Values::NONE): CreateCommandOptions
    {
        return new CreateCommandOptions($device, $sim, $callbackMethod, $callbackUrl, $commandMode, $includeSid);
    }
}

class ReadCommandOptions extends Options
{
    public function __construct(string $device = Values::NONE, string $sim = Values::NONE, string $status = Values::NONE, string $direction = Values::NONE)
    {
        $this->options['device'] = $device;
        $this->options['sim'] = $sim;
        $this->options['status'] = $status;
        $this->options['direction'] = $direction;
    }

    public function setDevice(string $device): self
    {
        $this->options['device'] = $device;
        return $this;
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
        return '[Twilio.Preview.Wireless.ReadCommandOptions ' . $options . ']';
    }
}

class CreateCommandOptions extends Options
{
    public function __construct(string $device = Values::NONE, string $sim = Values::NONE, string $callbackMethod = Values::NONE, string $callbackUrl = Values::NONE, string $commandMode = Values::NONE, string $includeSid = Values::NONE)
    {
        $this->options['device'] = $device;
        $this->options['sim'] = $sim;
        $this->options['callbackMethod'] = $callbackMethod;
        $this->options['callbackUrl'] = $callbackUrl;
        $this->options['commandMode'] = $commandMode;
        $this->options['includeSid'] = $includeSid;
    }

    public function setDevice(string $device): self
    {
        $this->options['device'] = $device;
        return $this;
    }

    public function setSim(string $sim): self
    {
        $this->options['sim'] = $sim;
        return $this;
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

    public function setCommandMode(string $commandMode): self
    {
        $this->options['commandMode'] = $commandMode;
        return $this;
    }

    public function setIncludeSid(string $includeSid): self
    {
        $this->options['includeSid'] = $includeSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Wireless.CreateCommandOptions ' . $options . ']';
    }
}