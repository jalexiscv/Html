<?php

namespace Twilio\Rest\Studio\V1\Flow\Engagement\Step;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class StepContextContext extends InstanceContext
{
    public function __construct(Version $version, $flowSid, $engagementSid, $stepSid)
    {
        parent::__construct($version);
        $this->solution = ['flowSid' => $flowSid, 'engagementSid' => $engagementSid, 'stepSid' => $stepSid,];
        $this->uri = '/Flows/' . rawurlencode($flowSid) . '/Engagements/' . rawurlencode($engagementSid) . '/Steps/' . rawurlencode($stepSid) . '/Context';
    }

    public function fetch(): StepContextInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new StepContextInstance($this->version, $payload, $this->solution['flowSid'], $this->solution['engagementSid'], $this->solution['stepSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Studio.V1.StepContextContext ' . implode(' ', $context) . ']';
    }
}