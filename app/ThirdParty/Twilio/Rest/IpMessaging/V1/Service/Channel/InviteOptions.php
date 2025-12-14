<?php

namespace Twilio\Rest\IpMessaging\V1\Service\Channel;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class InviteOptions
{
    public static function create(string $roleSid = Values::NONE): CreateInviteOptions
    {
        return new CreateInviteOptions($roleSid);
    }

    public static function read(array $identity = Values::ARRAY_NONE): ReadInviteOptions
    {
        return new ReadInviteOptions($identity);
    }
}

class CreateInviteOptions extends Options
{
    public function __construct(string $roleSid = Values::NONE)
    {
        $this->options['roleSid'] = $roleSid;
    }

    public function setRoleSid(string $roleSid): self
    {
        $this->options['roleSid'] = $roleSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.IpMessaging.V1.CreateInviteOptions ' . $options . ']';
    }
}

class ReadInviteOptions extends Options
{
    public function __construct(array $identity = Values::ARRAY_NONE)
    {
        $this->options['identity'] = $identity;
    }

    public function setIdentity(array $identity): self
    {
        $this->options['identity'] = $identity;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.IpMessaging.V1.ReadInviteOptions ' . $options . ']';
    }
}