<?php

namespace Twilio\Rest\Insights\V1;

use Twilio\ListResource;
use Twilio\Version;

class CallList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(string $sid): CallContext
    {
        return new CallContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Insights.V1.CallList]';
    }
}