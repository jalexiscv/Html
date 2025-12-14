<?php

namespace Twilio\Rest\Conversations\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class CredentialContext extends InstanceContext
{
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Credentials/' . rawurlencode($sid) . '';
    }

    public function update(array $options = []): CredentialInstance
    {
        $options = new Values($options);
        $data = Values::of(['Type' => $options['type'], 'FriendlyName' => $options['friendlyName'], 'Certificate' => $options['certificate'], 'PrivateKey' => $options['privateKey'], 'Sandbox' => Serialize::booleanToString($options['sandbox']), 'ApiKey' => $options['apiKey'], 'Secret' => $options['secret'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new CredentialInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function fetch(): CredentialInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new CredentialInstance($this->version, $payload, $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Conversations.V1.CredentialContext ' . implode(' ', $context) . ']';
    }
}