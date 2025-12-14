<?php

namespace Twilio\Rest\Messaging\V1;

use Twilio\ListResource;
use Twilio\Version;

class DeactivationsList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(): DeactivationsContext
    {
        return new DeactivationsContext($this->version);
    }

    public function __toString(): string
    {
        return '[Twilio.Messaging.V1.DeactivationsList]';
    }
}