<?php

namespace Twilio\Rest\Api\V2010\Account\Sip\CredentialList;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class CredentialOptions
{
    public static function update(string $password = Values::NONE): UpdateCredentialOptions
    {
        return new UpdateCredentialOptions($password);
    }
}

class UpdateCredentialOptions extends Options
{
    public function __construct(string $password = Values::NONE)
    {
        $this->options['password'] = $password;
    }

    public function setPassword(string $password): self
    {
        $this->options['password'] = $password;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.UpdateCredentialOptions ' . $options . ']';
    }
}