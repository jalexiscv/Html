<?php

namespace Twilio\Rest\Api\V2010\Account\Queue;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class MemberOptions
{
    public static function update(string $method = Values::NONE): UpdateMemberOptions
    {
        return new UpdateMemberOptions($method);
    }
}

class UpdateMemberOptions extends Options
{
    public function __construct(string $method = Values::NONE)
    {
        $this->options['method'] = $method;
    }

    public function setMethod(string $method): self
    {
        $this->options['method'] = $method;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.UpdateMemberOptions ' . $options . ']';
    }
}