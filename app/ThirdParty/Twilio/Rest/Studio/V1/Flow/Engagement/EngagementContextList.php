<?php

namespace Twilio\Rest\Studio\V1\Flow\Engagement;

use Twilio\ListResource;
use Twilio\Version;

class EngagementContextList extends ListResource
{
    public function __construct(Version $version, string $flowSid, string $engagementSid)
    {
        parent::__construct($version);
        $this->solution = ['flowSid' => $flowSid, 'engagementSid' => $engagementSid,];
    }

    public function getContext(): EngagementContextContext
    {
        return new EngagementContextContext($this->version, $this->solution['flowSid'], $this->solution['engagementSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V1.EngagementContextList]';
    }
}