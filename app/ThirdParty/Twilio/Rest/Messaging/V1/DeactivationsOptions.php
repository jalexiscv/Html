<?php

namespace Twilio\Rest\Messaging\V1;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class DeactivationsOptions
{
    public static function fetch(DateTime $date = Values::NONE): FetchDeactivationsOptions
    {
        return new FetchDeactivationsOptions($date);
    }
}

class FetchDeactivationsOptions extends Options
{
    public function __construct(DateTime $date = Values::NONE)
    {
        $this->options['date'] = $date;
    }

    public function setDate(DateTime $date): self
    {
        $this->options['date'] = $date;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Messaging.V1.FetchDeactivationsOptions ' . $options . ']';
    }
}