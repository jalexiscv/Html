<?php

namespace Twilio\Rest\Autopilot\V1\Assistant;

use Twilio\ListResource;
use Twilio\Version;

class StyleSheetList extends ListResource
{
    public function __construct(Version $version, string $assistantSid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid,];
    }

    public function getContext(): StyleSheetContext
    {
        return new StyleSheetContext($this->version, $this->solution['assistantSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Autopilot.V1.StyleSheetList]';
    }
}