<?php

namespace Twilio\Rest\Preview\Wireless\Sim;

use Twilio\ListResource;
use Twilio\Version;

class UsageList extends ListResource
{
    public function __construct(Version $version, string $simSid)
    {
        parent::__construct($version);
        $this->solution = ['simSid' => $simSid,];
    }

    public function getContext(): UsageContext
    {
        return new UsageContext($this->version, $this->solution['simSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Wireless.UsageList]';
    }
}