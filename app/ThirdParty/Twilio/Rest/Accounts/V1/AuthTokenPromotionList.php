<?php

namespace Twilio\Rest\Accounts\V1;

use Twilio\ListResource;
use Twilio\Version;

class AuthTokenPromotionList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(): AuthTokenPromotionContext
    {
        return new AuthTokenPromotionContext($this->version);
    }

    public function __toString(): string
    {
        return '[Twilio.Accounts.V1.AuthTokenPromotionList]';
    }
}