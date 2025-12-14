<?php

namespace Twilio\Rest\Preview\Understand\Assistant;

use Twilio\ListResource;
use Twilio\Version;

class AssistantInitiationActionsList extends ListResource
{
    public function __construct(Version $version, string $assistantSid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid,];
    }

    public function getContext(): AssistantInitiationActionsContext
    {
        return new AssistantInitiationActionsContext($this->version, $this->solution['assistantSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Understand.AssistantInitiationActionsList]';
    }
}