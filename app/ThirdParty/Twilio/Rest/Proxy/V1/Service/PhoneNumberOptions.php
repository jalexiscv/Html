<?php

namespace Twilio\Rest\Proxy\V1\Service;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class PhoneNumberOptions
{
    public static function create(string $sid = Values::NONE, string $phoneNumber = Values::NONE, bool $isReserved = Values::NONE): CreatePhoneNumberOptions
    {
        return new CreatePhoneNumberOptions($sid, $phoneNumber, $isReserved);
    }

    public static function update(bool $isReserved = Values::NONE): UpdatePhoneNumberOptions
    {
        return new UpdatePhoneNumberOptions($isReserved);
    }
}

class CreatePhoneNumberOptions extends Options
{
    public function __construct(string $sid = Values::NONE, string $phoneNumber = Values::NONE, bool $isReserved = Values::NONE)
    {
        $this->options['sid'] = $sid;
        $this->options['phoneNumber'] = $phoneNumber;
        $this->options['isReserved'] = $isReserved;
    }

    public function setSid(string $sid): self
    {
        $this->options['sid'] = $sid;
        return $this;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->options['phoneNumber'] = $phoneNumber;
        return $this;
    }

    public function setIsReserved(bool $isReserved): self
    {
        $this->options['isReserved'] = $isReserved;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Proxy.V1.CreatePhoneNumberOptions ' . $options . ']';
    }
}

class UpdatePhoneNumberOptions extends Options
{
    public function __construct(bool $isReserved = Values::NONE)
    {
        $this->options['isReserved'] = $isReserved;
    }

    public function setIsReserved(bool $isReserved): self
    {
        $this->options['isReserved'] = $isReserved;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Proxy.V1.UpdatePhoneNumberOptions ' . $options . ']';
    }
}