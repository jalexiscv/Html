<?php

namespace Twilio\Rest\Studio\V1\Flow\Engagement;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class EngagementContextContext extends InstanceContext
{
    public function __construct(Version $version, $flowSid, $engagementSid)
    {
        parent::__construct($version);
        $this->solution = ['flowSid' => $flowSid, 'engagementSid' => $engagementSid,];
        $this->uri = '/Flows/' . rawurlencode($flowSid) . '/Engagements/' . rawurlencode($engagementSid) . '/Context';
    }

    public function fetch(): EngagementContextInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new EngagementContextInstance($this->version, $payload, $this->solution['flowSid'], $this->solution['engagementSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Studio.V1.EngagementContextContext ' . implode(' ', $context) . ']';
    }
}