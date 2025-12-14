<?php

namespace Twilio\Rest\Pricing\V2\Voice;

use Twilio\ListResource;
use Twilio\Version;

class NumberList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(string $destinationNumber): NumberContext
    {
        return new NumberContext($this->version, $destinationNumber);
    }

    public function __toString(): string
    {
        return '[Twilio.Pricing.V2.NumberList]';
    }
}