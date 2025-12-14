<?php

namespace Twilio\Rest\Preview\TrustedComms\Business;

use Twilio\ListResource;
use Twilio\Version;

class BrandList extends ListResource
{
    public function __construct(Version $version, string $businessSid)
    {
        parent::__construct($version);
        $this->solution = ['businessSid' => $businessSid,];
    }

    public function getContext(string $sid): BrandContext
    {
        return new BrandContext($this->version, $this->solution['businessSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.TrustedComms.BrandList]';
    }
}