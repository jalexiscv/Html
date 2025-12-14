<?php

namespace Twilio\Rest\Chat\V2\Service;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class BindingOptions
{
    public static function read(array $bindingType = Values::ARRAY_NONE, array $identity = Values::ARRAY_NONE): ReadBindingOptions
    {
        return new ReadBindingOptions($bindingType, $identity);
    }
}

class ReadBindingOptions extends Options
{
    public function __construct(array $bindingType = Values::ARRAY_NONE, array $identity = Values::ARRAY_NONE)
    {
        $this->options['bindingType'] = $bindingType;
        $this->options['identity'] = $identity;
    }

    public function setBindingType(array $bindingType): self
    {
        $this->options['bindingType'] = $bindingType;
        return $this;
    }

    public function setIdentity(array $identity): self
    {
        $this->options['identity'] = $identity;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Chat.V2.ReadBindingOptions ' . $options . ']';
    }
}