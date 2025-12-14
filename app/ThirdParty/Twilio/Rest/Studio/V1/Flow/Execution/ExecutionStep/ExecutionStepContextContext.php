<?php

namespace Twilio\Rest\Studio\V1\Flow\Execution\ExecutionStep;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class ExecutionStepContextContext extends InstanceContext
{
    public function __construct(Version $version, $flowSid, $executionSid, $stepSid)
    {
        parent::__construct($version);
        $this->solution = ['flowSid' => $flowSid, 'executionSid' => $executionSid, 'stepSid' => $stepSid,];
        $this->uri = '/Flows/' . rawurlencode($flowSid) . '/Executions/' . rawurlencode($executionSid) . '/Steps/' . rawurlencode($stepSid) . '/Context';
    }

    public function fetch(): ExecutionStepContextInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ExecutionStepContextInstance($this->version, $payload, $this->solution['flowSid'], $this->solution['executionSid'], $this->solution['stepSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Studio.V1.ExecutionStepContextContext ' . implode(' ', $context) . ']';
    }
}