<?php

namespace Twilio\Rest\Studio\V1\Flow\Execution\ExecutionStep;

use Twilio\ListResource;
use Twilio\Version;

class ExecutionStepContextList extends ListResource
{
    public function __construct(Version $version, string $flowSid, string $executionSid, string $stepSid)
    {
        parent::__construct($version);
        $this->solution = ['flowSid' => $flowSid, 'executionSid' => $executionSid, 'stepSid' => $stepSid,];
    }

    public function getContext(): ExecutionStepContextContext
    {
        return new ExecutionStepContextContext($this->version, $this->solution['flowSid'], $this->solution['executionSid'], $this->solution['stepSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V1.ExecutionStepContextList]';
    }
}