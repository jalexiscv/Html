<?php

namespace Twilio\Rest\Api\V2010;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class AccountOptions
{
    public static function create(string $friendlyName = Values::NONE): CreateAccountOptions
    {
        return new CreateAccountOptions($friendlyName);
    }

    public static function read(string $friendlyName = Values::NONE, string $status = Values::NONE): ReadAccountOptions
    {
        return new ReadAccountOptions($friendlyName, $status);
    }

    public static function update(string $friendlyName = Values::NONE, string $status = Values::NONE): UpdateAccountOptions
    {
        return new UpdateAccountOptions($friendlyName, $status);
    }
}

class CreateAccountOptions extends Options
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
        return '[Twilio.Api.V2010.CreateAccountOptions ' . $options . ']';
    }
}

class ReadAccountOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $status = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['status'] = $status;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.ReadAccountOptions ' . $options . ']';
    }
}

class UpdateAccountOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $status = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['status'] = $status;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.UpdateAccountOptions ' . $options . ']';
    }
}