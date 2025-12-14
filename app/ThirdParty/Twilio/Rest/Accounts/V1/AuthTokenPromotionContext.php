<?php

namespace Twilio\Rest\Accounts\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;

class AuthTokenPromotionContext extends InstanceContext
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/AuthTokens/Promote';
    }

    public function update(): AuthTokenPromotionInstance
    {
        $payload = $this->version->update('POST', $this->uri);
        return new AuthTokenPromotionInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Accounts.V1.AuthTokenPromotionContext ' . implode(' ', $context) . ']';
    }
}