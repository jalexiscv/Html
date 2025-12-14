<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class ConnectAppContext extends InstanceContext
{
    public function __construct(Version $version, $accountSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/ConnectApps/' . rawurlencode($sid) . '.json';
    }

    public function fetch(): ConnectAppInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ConnectAppInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    public function update(array $options = []): ConnectAppInstance
    {
        $options = new Values($options);
        $data = Values::of(['AuthorizeRedirectUrl' => $options['authorizeRedirectUrl'], 'CompanyName' => $options['companyName'], 'DeauthorizeCallbackMethod' => $options['deauthorizeCallbackMethod'], 'DeauthorizeCallbackUrl' => $options['deauthorizeCallbackUrl'], 'Description' => $options['description'], 'FriendlyName' => $options['friendlyName'], 'HomepageUrl' => $options['homepageUrl'], 'Permissions' => Serialize::map($options['permissions'], function ($e) {
            return $e;
        }),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ConnectAppInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
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
        return '[Twilio.Api.V2010.ConnectAppContext ' . implode(' ', $context) . ']';
    }
}