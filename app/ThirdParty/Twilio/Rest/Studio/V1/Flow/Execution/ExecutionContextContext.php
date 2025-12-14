<?php

namespace Twilio\Rest\Studio\V1\Flow\Execution;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class ExecutionContextContext extends InstanceContext
{
    public function __construct(Version $version, $flowSid, $executionSid)
    {
        parent::__construct($version);
        $this->solution = ['flowSid' => $flowSid, 'executionSid' => $executionSid,];
        $this->uri = '/Flows/' . rawurlencode($flowSid) . '/Executions/' . rawurlencode($executionSid) . '/Context';
    }

    public function fetch(): ExecutionContextInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ExecutionContextInstance($this->version, $payload, $this->solution['flowSid'], $this->solution['executionSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Studio.V1.ExecutionContextContext ' . implode(' ', $context) . ']';
    }
}