<?php

namespace Twilio\Rest\Preview\Understand\Assistant;

use Twilio\ListResource;
use Twilio\Version;

class AssistantFallbackActionsList extends ListResource
{
    public function __construct(Version $version, string $assistantSid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid,];
    }

    public function getContext(): AssistantFallbackActionsContext
    {
        return new AssistantFallbackActionsContext($this->version, $this->solution['assistantSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Understand.AssistantFallbackActionsList]';
    }
}