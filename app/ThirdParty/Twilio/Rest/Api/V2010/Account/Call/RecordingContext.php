<?php

namespace Twilio\Rest\Api\V2010\Account\Call;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class RecordingContext extends InstanceContext
{
    public function __construct(Version $version, $accountSid, $callSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'callSid' => $callSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Calls/' . rawurlencode($callSid) . '/Recordings/' . rawurlencode($sid) . '.json';
    }

    public function update(string $status, array $options = []): RecordingInstance
    {
        $options = new Values($options);
        $data = Values::of(['Status' => $status, 'PauseBehavior' => $options['pauseBehavior'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new RecordingInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['callSid'], $this->solution['sid']);
    }

    public function fetch(): RecordingInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new RecordingInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['callSid'], $this->solution['sid']);
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
        return '[Twilio.Api.V2010.RecordingContext ' . implode(' ', $context) . ']';
    }
}