<?php

namespace Twilio\Rest\Insights\V1\Call;

use Twilio\ListResource;
use Twilio\Version;

class CallSummaryList extends ListResource
{
    public function __construct(Version $version, string $callSid)
    {
        parent::__construct($version);
        $this->solution = ['callSid' => $callSid,];
    }

    public function getContext(): CallSummaryContext
    {
        return new CallSummaryContext($this->version, $this->solution['callSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Insights.V1.CallSummaryList]';
    }
}