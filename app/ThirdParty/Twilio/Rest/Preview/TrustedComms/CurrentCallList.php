<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\ListResource;
use Twilio\Version;

class CurrentCallList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(): CurrentCallContext
    {
        return new CurrentCallContext($this->version);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.TrustedComms.CurrentCallList]';
    }
}