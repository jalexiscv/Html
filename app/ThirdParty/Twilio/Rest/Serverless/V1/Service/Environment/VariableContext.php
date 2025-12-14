<?php

namespace Twilio\Rest\Serverless\V1\Service\Environment;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class VariableContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $environmentSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'environmentSid' => $environmentSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Environments/' . rawurlencode($environmentSid) . '/Variables/' . rawurlencode($sid) . '';
    }

    public function fetch(): VariableInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new VariableInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['environmentSid'], $this->solution['sid']);
    }

    public function update(array $options = []): VariableInstance
    {
        $options = new Values($options);
        $data = Values::of(['Key' => $options['key'], 'Value' => $options['value'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new VariableInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['environmentSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Serverless.V1.VariableContext ' . implode(' ', $context) . ']';
    }
}