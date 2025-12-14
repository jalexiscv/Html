<?php

namespace Twilio\Rest\Api\V2010\Account\Sip\Domain\AuthTypes\AuthTypeRegistrations;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class AuthRegistrationsCredentialListMappingContext extends InstanceContext
{
    public function __construct(Version $version, $accountSid, $domainSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'domainSid' => $domainSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/SIP/Domains/' . rawurlencode($domainSid) . '/Auth/Registrations/CredentialListMappings/' . rawurlencode($sid) . '.json';
    }

    public function fetch(): AuthRegistrationsCredentialListMappingInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new AuthRegistrationsCredentialListMappingInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['domainSid'], $this->solution['sid']);
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
        return '[Twilio.Api.V2010.AuthRegistrationsCredentialListMappingContext ' . implode(' ', $context) . ']';
    }
}