<?php

namespace Twilio\Rest\Studio\V2\Flow\Execution;

use Twilio\ListResource;
use Twilio\Version;

class ExecutionContextList extends ListResource
{
    public function __construct(Version $version, string $flowSid, string $executionSid)
    {
        parent::__construct($version);
        $this->solution = ['flowSid' => $flowSid, 'executionSid' => $executionSid,];
    }

    public function getContext(): ExecutionContextContext
    {
        return new ExecutionContextContext($this->version, $this->solution['flowSid'], $this->solution['executionSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V2.ExecutionContextList]';
    }
}