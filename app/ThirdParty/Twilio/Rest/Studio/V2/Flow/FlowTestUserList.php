<?php

namespace Twilio\Rest\Studio\V2\Flow;

use Twilio\ListResource;
use Twilio\Version;

class FlowTestUserList extends ListResource
{
    public function __construct(Version $version, string $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
    }

    public function getContext(): FlowTestUserContext
    {
        return new FlowTestUserContext($this->version, $this->solution['sid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V2.FlowTestUserList]';
    }
}