<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class AuthorizedConnectAppContext extends InstanceContext
{
    public function __construct(Version $version, $accountSid, $connectAppSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'connectAppSid' => $connectAppSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/AuthorizedConnectApps/' . rawurlencode($connectAppSid) . '.json';
    }

    public function fetch(): AuthorizedConnectAppInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new AuthorizedConnectAppInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['connectAppSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.AuthorizedConnectAppContext ' . implode(' ', $context) . ']';
    }
}