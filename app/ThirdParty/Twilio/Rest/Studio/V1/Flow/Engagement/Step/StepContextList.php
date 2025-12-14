<?php

namespace Twilio\Rest\Studio\V1\Flow\Engagement\Step;

use Twilio\ListResource;
use Twilio\Version;

class StepContextList extends ListResource
{
    public function __construct(Version $version, string $flowSid, string $engagementSid, string $stepSid)
    {
        parent::__construct($version);
        $this->solution = ['flowSid' => $flowSid, 'engagementSid' => $engagementSid, 'stepSid' => $stepSid,];
    }

    public function getContext(): StepContextContext
    {
        return new StepContextContext($this->version, $this->solution['flowSid'], $this->solution['engagementSid'], $this->solution['stepSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V1.StepContextList]';
    }
}