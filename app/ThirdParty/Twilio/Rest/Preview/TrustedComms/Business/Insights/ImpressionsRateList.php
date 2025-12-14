<?php

namespace Twilio\Rest\Preview\TrustedComms\Business\Insights;

use Twilio\ListResource;
use Twilio\Version;

class ImpressionsRateList extends ListResource
{
    public function __construct(Version $version, string $businessSid)
    {
        parent::__construct($version);
        $this->solution = ['businessSid' => $businessSid,];
    }

    public function getContext(): ImpressionsRateContext
    {
        return new ImpressionsRateContext($this->version, $this->solution['businessSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.TrustedComms.ImpressionsRateList]';
    }
}