<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\ListResource;
use Twilio\Version;

class BrandsInformationList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(): BrandsInformationContext
    {
        return new BrandsInformationContext($this->version);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.TrustedComms.BrandsInformationList]';
    }
}