<?php

namespace Twilio\Rest\Autopilot\V1\Assistant;

use Twilio\ListResource;
use Twilio\Version;

class DialogueList extends ListResource
{
    public function __construct(Version $version, string $assistantSid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid,];
    }

    public function getContext(string $sid): DialogueContext
    {
        return new DialogueContext($this->version, $this->solution['assistantSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Autopilot.V1.DialogueList]';
    }
}