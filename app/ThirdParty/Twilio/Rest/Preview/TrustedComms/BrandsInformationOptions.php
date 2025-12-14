<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class BrandsInformationOptions
{
    public static function fetch(string $ifNoneMatch = Values::NONE): FetchBrandsInformationOptions
    {
        return new FetchBrandsInformationOptions($ifNoneMatch);
    }
}

class FetchBrandsInformationOptions extends Options
{
    public function __construct(string $ifNoneMatch = Values::NONE)
    {
        $this->options['ifNoneMatch'] = $ifNoneMatch;
    }

    public function setIfNoneMatch(string $ifNoneMatch): self
    {
        $this->options['ifNoneMatch'] = $ifNoneMatch;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.TrustedComms.FetchBrandsInformationOptions ' . $options . ']';
    }
}