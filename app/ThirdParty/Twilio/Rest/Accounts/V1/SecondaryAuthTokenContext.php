<?php

namespace Twilio\Rest\Accounts\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;

class SecondaryAuthTokenContext extends InstanceContext
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/AuthTokens/Secondary';
    }

    public function create(): SecondaryAuthTokenInstance
    {
        $payload = $this->version->create('POST', $this->uri);
        return new SecondaryAuthTokenInstance($this->version, $payload);
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
        return '[Twilio.Accounts.V1.SecondaryAuthTokenContext ' . implode(' ', $context) . ']';
    }
}