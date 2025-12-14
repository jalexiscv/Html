<?php

namespace Twilio\Rest\Voice\V1\DialingPermissions;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class SettingsInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload)
    {
        parent::__construct($version);
        $this->properties = ['dialingPermissionsInheritance' => Values::array_get($payload, 'dialing_permissions_inheritance'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = [];
    }

    protected function proxy(): SettingsContext
    {
        if (!$this->context) {
            $this->context = new SettingsContext($this->version);
        }
        return $this->context;
    }

    public function fetch(): SettingsInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): SettingsInstance
    {
        return $this->proxy()->update($options);
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown property: ' . $name);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Voice.V1.SettingsInstance ' . implode(' ', $context) . ']';
    }
}