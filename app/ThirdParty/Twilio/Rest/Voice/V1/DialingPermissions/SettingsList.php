<?php

namespace Twilio\Rest\Voice\V1\DialingPermissions;

use Twilio\ListResource;
use Twilio\Version;

class SettingsList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(): SettingsContext
    {
        return new SettingsContext($this->version);
    }

    public function __toString(): string
    {
        return '[Twilio.Voice.V1.SettingsList]';
    }
}