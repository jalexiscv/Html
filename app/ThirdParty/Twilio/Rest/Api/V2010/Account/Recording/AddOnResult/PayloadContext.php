<?php

namespace Twilio\Rest\Api\V2010\Account\Recording\AddOnResult;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class PayloadContext extends InstanceContext
{
    public function __construct(Version $version, $accountSid, $referenceSid, $addOnResultSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'referenceSid' => $referenceSid, 'addOnResultSid' => $addOnResultSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Recordings/' . rawurlencode($referenceSid) . '/AddOnResults/' . rawurlencode($addOnResultSid) . '/Payloads/' . rawurlencode($sid) . '.json';
    }

    public function fetch(): PayloadInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new PayloadInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['referenceSid'], $this->solution['addOnResultSid'], $this->solution['sid']);
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
        return '[Twilio.Api.V2010.PayloadContext ' . implode(' ', $context) . ']';
    }
}