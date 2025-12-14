<?php

namespace Twilio\Rest\Preview\Understand\Assistant;

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
        return '[Twilio.Preview.Understand.DialogueList]';
    }
}