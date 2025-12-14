<?php

namespace Twilio\Rest\Api\V2010\Account\Recording;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class TranscriptionContext extends InstanceContext
{
    public function __construct(Version $version, $accountSid, $recordingSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'recordingSid' => $recordingSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Recordings/' . rawurlencode($recordingSid) . '/Transcriptions/' . rawurlencode($sid) . '.json';
    }

    public function fetch(): TranscriptionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new TranscriptionInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['recordingSid'], $this->solution['sid']);
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
        return '[Twilio.Api.V2010.TranscriptionContext ' . implode(' ', $context) . ']';
    }
}