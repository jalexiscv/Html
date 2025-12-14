<?php

namespace Twilio\Rest\Accounts\V1;

use Twilio\ListResource;
use Twilio\Version;

class SecondaryAuthTokenList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(): SecondaryAuthTokenContext
    {
        return new SecondaryAuthTokenContext($this->version);
    }

    public function __toString(): string
    {
        return '[Twilio.Accounts.V1.SecondaryAuthTokenList]';
    }
}