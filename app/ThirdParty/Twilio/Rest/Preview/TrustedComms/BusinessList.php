<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\ListResource;
use Twilio\Version;

class BusinessList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(string $sid): BusinessContext
    {
        return new BusinessContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.TrustedComms.BusinessList]';
    }
}