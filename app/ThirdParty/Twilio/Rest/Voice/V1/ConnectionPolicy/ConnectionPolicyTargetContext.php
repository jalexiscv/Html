<?php

namespace Twilio\Rest\Voice\V1\ConnectionPolicy;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class ConnectionPolicyTargetContext extends InstanceContext
{
    public function __construct(Version $version, $connectionPolicySid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['connectionPolicySid' => $connectionPolicySid, 'sid' => $sid,];
        $this->uri = '/ConnectionPolicies/' . rawurlencode($connectionPolicySid) . '/Targets/' . rawurlencode($sid) . '';
    }

    public function fetch(): ConnectionPolicyTargetInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ConnectionPolicyTargetInstance($this->version, $payload, $this->solution['connectionPolicySid'], $this->solution['sid']);
    }

    public function update(array $options = []): ConnectionPolicyTargetInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'Target' => $options['target'], 'Priority' => $options['priority'], 'Weight' => $options['weight'], 'Enabled' => Serialize::booleanToString($options['enabled']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ConnectionPolicyTargetInstance($this->version, $payload, $this->solution['connectionPolicySid'], $this->solution['sid']);
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
        return '[Twilio.Voice.V1.ConnectionPolicyTargetContext ' . implode(' ', $context) . ']';
    }
}