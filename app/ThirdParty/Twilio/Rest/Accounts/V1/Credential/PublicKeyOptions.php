<?php

namespace Twilio\Rest\Accounts\V1\Credential;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class PublicKeyOptions
{
    public static function create(string $friendlyName = Values::NONE, string $accountSid = Values::NONE): CreatePublicKeyOptions
    {
        return new CreatePublicKeyOptions($friendlyName, $accountSid);
    }

    public static function update(string $friendlyName = Values::NONE): UpdatePublicKeyOptions
    {
        return new UpdatePublicKeyOptions($friendlyName);
    }
}

class CreatePublicKeyOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $accountSid = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['accountSid'] = $accountSid;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setAccountSid(string $accountSid): self
    {
        $this->options['accountSid'] = $accountSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Accounts.V1.CreatePublicKeyOptions ' . $options . ']';
    }
}

class UpdatePublicKeyOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Accounts.V1.UpdatePublicKeyOptions ' . $options . ']';
    }
}