<?php

namespace Twilio\Rest\Pricing\V1\Voice;

use Twilio\ListResource;
use Twilio\Version;

class NumberList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(string $number): NumberContext
    {
        return new NumberContext($this->version, $number);
    }

    public function __toString(): string
    {
        return '[Twilio.Pricing.V1.NumberList]';
    }
}