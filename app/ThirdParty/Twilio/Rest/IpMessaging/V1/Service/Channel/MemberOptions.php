<?php

namespace Twilio\Rest\IpMessaging\V1\Service\Channel;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class MemberOptions
{
    public static function create(string $roleSid = Values::NONE): CreateMemberOptions
    {
        return new CreateMemberOptions($roleSid);
    }

    public static function read(array $identity = Values::ARRAY_NONE): ReadMemberOptions
    {
        return new ReadMemberOptions($identity);
    }

    public static function update(string $roleSid = Values::NONE, int $lastConsumedMessageIndex = Values::NONE): UpdateMemberOptions
    {
        return new UpdateMemberOptions($roleSid, $lastConsumedMessageIndex);
    }
}

class CreateMemberOptions extends Options
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
        return '[Twilio.IpMessaging.V1.CreateMemberOptions ' . $options . ']';
    }
}

class ReadMemberOptions extends Options
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
        return '[Twilio.IpMessaging.V1.ReadMemberOptions ' . $options . ']';
    }
}

class UpdateMemberOptions extends Options
{
    public function __construct(string $roleSid = Values::NONE, int $lastConsumedMessageIndex = Values::NONE)
    {
        $this->options['roleSid'] = $roleSid;
        $this->options['lastConsumedMessageIndex'] = $lastConsumedMessageIndex;
    }

    public function setRoleSid(string $roleSid): self
    {
        $this->options['roleSid'] = $roleSid;
        return $this;
    }

    public function setLastConsumedMessageIndex(int $lastConsumedMessageIndex): self
    {
        $this->options['lastConsumedMessageIndex'] = $lastConsumedMessageIndex;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.IpMessaging.V1.UpdateMemberOptions ' . $options . ']';
    }
}