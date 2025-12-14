<?php

namespace Twilio\Rest\Voice\V1\DialingPermissions;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;

class SettingsContext extends InstanceContext
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Settings';
    }

    public function fetch(): SettingsInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SettingsInstance($this->version, $payload);
    }

    public function update(array $options = []): SettingsInstance
    {
        $options = new Values($options);
        $data = Values::of(['DialingPermissionsInheritance' => Serialize::booleanToString($options['dialingPermissionsInheritance']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new SettingsInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Voice.V1.SettingsContext ' . implode(' ', $context) . ']';
    }
}