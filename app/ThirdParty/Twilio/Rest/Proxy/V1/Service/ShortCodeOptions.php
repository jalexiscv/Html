<?php

namespace Twilio\Rest\Proxy\V1\Service;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ShortCodeOptions
{
    public static function update(bool $isReserved = Values::NONE): UpdateShortCodeOptions
    {
        return new UpdateShortCodeOptions($isReserved);
    }
}

class UpdateShortCodeOptions extends Options
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
        return '[Twilio.Proxy.V1.UpdateShortCodeOptions ' . $options . ']';
    }
}