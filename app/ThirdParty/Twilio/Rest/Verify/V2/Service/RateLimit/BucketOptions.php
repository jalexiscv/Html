<?php

namespace Twilio\Rest\Verify\V2\Service\RateLimit;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class BucketOptions
{
    public static function update(int $max = Values::NONE, int $interval = Values::NONE): UpdateBucketOptions
    {
        return new UpdateBucketOptions($max, $interval);
    }
}

class UpdateBucketOptions extends Options
{
    public function __construct(int $max = Values::NONE, int $interval = Values::NONE)
    {
        $this->options['max'] = $max;
        $this->options['interval'] = $interval;
    }

    public function setMax(int $max): self
    {
        $this->options['max'] = $max;
        return $this;
    }

    public function setInterval(int $interval): self
    {
        $this->options['interval'] = $interval;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Verify.V2.UpdateBucketOptions ' . $options . ']';
    }
}