<?php

namespace Twilio\Rest\Preview\Sync\Service\SyncMap;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class SyncMapPermissionInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $mapSid, string $identity = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'mapSid' => Values::array_get($payload, 'map_sid'), 'identity' => Values::array_get($payload, 'identity'), 'read' => Values::array_get($payload, 'read'), 'write' => Values::array_get($payload, 'write'), 'manage' => Values::array_get($payload, 'manage'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['serviceSid' => $serviceSid, 'mapSid' => $mapSid, 'identity' => $identity ?: $this->properties['identity'],];
    }

    protected function proxy(): SyncMapPermissionContext
    {
        if (!$this->context) {
            $this->context = new SyncMapPermissionContext($this->version, $this->solution['serviceSid'], $this->solution['mapSid'], $this->solution['identity']);
        }
        return $this->context;
    }

    public function fetch(): SyncMapPermissionInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(bool $read, bool $write, bool $manage): SyncMapPermissionInstance
    {
        return $this->proxy()->update($read, $write, $manage);
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
        return '[Twilio.Preview.Sync.SyncMapPermissionInstance ' . implode(' ', $context) . ']';
    }
}