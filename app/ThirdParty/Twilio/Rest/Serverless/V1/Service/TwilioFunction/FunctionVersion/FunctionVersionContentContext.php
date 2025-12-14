<?php

namespace Twilio\Rest\Serverless\V1\Service\TwilioFunction\FunctionVersion;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class FunctionVersionContentContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $functionSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'functionSid' => $functionSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Functions/' . rawurlencode($functionSid) . '/Versions/' . rawurlencode($sid) . '/Content';
    }

    public function fetch(): FunctionVersionContentInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new FunctionVersionContentInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['functionSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Serverless.V1.FunctionVersionContentContext ' . implode(' ', $context) . ']';
    }
}