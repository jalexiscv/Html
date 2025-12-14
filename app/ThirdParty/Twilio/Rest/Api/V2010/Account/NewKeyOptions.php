<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class NewKeyOptions
{
    public static function create(string $friendlyName = Values::NONE): CreateNewKeyOptions
    {
        return new CreateNewKeyOptions($friendlyName);
    }
}

class CreateNewKeyOptions extends Options
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
        return '[Twilio.Api.V2010.CreateNewKeyOptions ' . $options . ']';
    }
}