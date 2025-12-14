<?php

namespace Twilio\Rest\Accounts\V1\Credential;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class PublicKeyContext extends InstanceContext
{
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Credentials/PublicKeys/' . rawurlencode($sid) . '';
    }

    public function fetch(): PublicKeyInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new PublicKeyInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): PublicKeyInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new PublicKeyInstance($this->version, $payload, $this->solution['sid']);
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
        return '[Twilio.Accounts.V1.PublicKeyContext ' . implode(' ', $context) . ']';
    }
}