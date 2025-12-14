<?php

namespace Twilio\Rest\Serverless\V1\Service\Environment;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class DeploymentContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $environmentSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'environmentSid' => $environmentSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Environments/' . rawurlencode($environmentSid) . '/Deployments/' . rawurlencode($sid) . '';
    }

    public function fetch(): DeploymentInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new DeploymentInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['environmentSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Serverless.V1.DeploymentContext ' . implode(' ', $context) . ']';
    }
}