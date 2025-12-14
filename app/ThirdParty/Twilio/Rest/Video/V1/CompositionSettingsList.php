<?php

namespace Twilio\Rest\Video\V1;

use Twilio\ListResource;
use Twilio\Version;

class CompositionSettingsList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(): CompositionSettingsContext
    {
        return new CompositionSettingsContext($this->version);
    }

    public function __toString(): string
    {
        return '[Twilio.Video.V1.CompositionSettingsList]';
    }
}