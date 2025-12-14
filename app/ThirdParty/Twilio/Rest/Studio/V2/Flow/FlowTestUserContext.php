<?php

namespace Twilio\Rest\Studio\V2\Flow;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class FlowTestUserContext extends InstanceContext
{
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Flows/' . rawurlencode($sid) . '/TestUsers';
    }

    public function fetch(): FlowTestUserInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new FlowTestUserInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $testUsers): FlowTestUserInstance
    {
        $data = Values::of(['TestUsers' => Serialize::map($testUsers, function ($e) {
            return $e;
        }),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new FlowTestUserInstance($this->version, $payload, $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Studio.V2.FlowTestUserContext ' . implode(' ', $context) . ']';
    }
}