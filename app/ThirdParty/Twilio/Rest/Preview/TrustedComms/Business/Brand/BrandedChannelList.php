<?php

namespace Twilio\Rest\Preview\TrustedComms\Business\Brand;

use Twilio\ListResource;
use Twilio\Version;

class BrandedChannelList extends ListResource
{
    public function __construct(Version $version, string $businessSid, string $brandSid)
    {
        parent::__construct($version);
        $this->solution = ['businessSid' => $businessSid, 'brandSid' => $brandSid,];
    }

    public function getContext(string $sid): BrandedChannelContext
    {
        return new BrandedChannelContext($this->version, $this->solution['businessSid'], $this->solution['brandSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.TrustedComms.BrandedChannelList]';
    }
}