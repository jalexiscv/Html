<?php

namespace Twilio\Rest\Trunking\V1\Trunk;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class CredentialListContext extends InstanceContext
{
    public function __construct(Version $version, $trunkSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['trunkSid' => $trunkSid, 'sid' => $sid,];
        $this->uri = '/Trunks/' . rawurlencode($trunkSid) . '/CredentialLists/' . rawurlencode($sid) . '';
    }

    public function fetch(): CredentialListInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new CredentialListInstance($this->version, $payload, $this->solution['trunkSid'], $this->solution['sid']);
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
        return '[Twilio.Trunking.V1.CredentialListContext ' . implode(' ', $context) . ']';
    }
}