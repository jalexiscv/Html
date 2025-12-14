<?php

namespace Twilio\Rest\Voice\V1\DialingPermissions;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class SettingsOptions
{
    public static function update(bool $dialingPermissionsInheritance = Values::NONE): UpdateSettingsOptions
    {
        return new UpdateSettingsOptions($dialingPermissionsInheritance);
    }
}

class UpdateSettingsOptions extends Options
{
    public function __construct(bool $dialingPermissionsInheritance = Values::NONE)
    {
        $this->options['dialingPermissionsInheritance'] = $dialingPermissionsInheritance;
    }

    public function setDialingPermissionsInheritance(bool $dialingPermissionsInheritance): self
    {
        $this->options['dialingPermissionsInheritance'] = $dialingPermissionsInheritance;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Voice.V1.UpdateSettingsOptions ' . $options . ']';
    }
}