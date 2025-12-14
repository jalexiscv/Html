<?php

namespace Twilio\Rest\Lookups\V1;

use Twilio\ListResource;
use Twilio\Version;

class PhoneNumberList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(string $phoneNumber): PhoneNumberContext
    {
        return new PhoneNumberContext($this->version, $phoneNumber);
    }

    public function __toString(): string
    {
        return '[Twilio.Lookups.V1.PhoneNumberList]';
    }
}