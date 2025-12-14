<?php

namespace Twilio\Rest\Autopilot\V1\Assistant;

use Twilio\ListResource;
use Twilio\Version;

class DefaultsList extends ListResource
{
    public function __construct(Version $version, string $assistantSid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid,];
    }

    public function getContext(): DefaultsContext
    {
        return new DefaultsContext($this->version, $this->solution['assistantSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Autopilot.V1.DefaultsList]';
    }
}