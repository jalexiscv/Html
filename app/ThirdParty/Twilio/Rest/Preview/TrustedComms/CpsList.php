<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\ListResource;
use Twilio\Version;

class CpsList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(): CpsContext
    {
        return new CpsContext($this->version);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.TrustedComms.CpsList]';
    }
}