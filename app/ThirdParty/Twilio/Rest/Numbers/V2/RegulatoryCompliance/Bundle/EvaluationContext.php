<?php

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance\Bundle;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class EvaluationContext extends InstanceContext
{
    public function __construct(Version $version, $bundleSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['bundleSid' => $bundleSid, 'sid' => $sid,];
        $this->uri = '/RegulatoryCompliance/Bundles/' . rawurlencode($bundleSid) . '/Evaluations/' . rawurlencode($sid) . '';
    }

    public function fetch(): EvaluationInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new EvaluationInstance($this->version, $payload, $this->solution['bundleSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Numbers.V2.EvaluationContext ' . implode(' ', $context) . ']';
    }
}