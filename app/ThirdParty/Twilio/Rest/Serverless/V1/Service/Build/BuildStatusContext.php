<?php

namespace Twilio\Rest\Serverless\V1\Service\Build;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class BuildStatusContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Builds/' . rawurlencode($sid) . '/Status';
    }

    public function fetch(): BuildStatusInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new BuildStatusInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Serverless.V1.BuildStatusContext ' . implode(' ', $context) . ']';
    }
}