<?php

namespace Twilio\Rest\Chat\V2\Service\User;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class UserBindingOptions
{
    public static function read(array $bindingType = Values::ARRAY_NONE): ReadUserBindingOptions
    {
        return new ReadUserBindingOptions($bindingType);
    }
}

class ReadUserBindingOptions extends Options
{
    public function __construct(array $bindingType = Values::ARRAY_NONE)
    {
        $this->options['bindingType'] = $bindingType;
    }

    public function setBindingType(array $bindingType): self
    {
        $this->options['bindingType'] = $bindingType;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Chat.V2.ReadUserBindingOptions ' . $options . ']';
    }
}