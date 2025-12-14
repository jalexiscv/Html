<?php

namespace Twilio\Rest\Api\V2010\Account\Sip\CredentialList;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class CredentialContext extends InstanceContext
{
    public function __construct(Version $version, $accountSid, $credentialListSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'credentialListSid' => $credentialListSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/SIP/CredentialLists/' . rawurlencode($credentialListSid) . '/Credentials/' . rawurlencode($sid) . '.json';
    }

    public function fetch(): CredentialInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new CredentialInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['credentialListSid'], $this->solution['sid']);
    }

    public function update(array $options = []): CredentialInstance
    {
        $options = new Values($options);
        $data = Values::of(['Password' => $options['password'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new CredentialInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['credentialListSid'], $this->solution['sid']);
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
        return '[Twilio.Api.V2010.CredentialContext ' . implode(' ', $context) . ']';
    }
}