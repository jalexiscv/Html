<?php

namespace Twilio\Rest\Sync\V1\Service\Document;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class DocumentPermissionInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $documentSid, string $identity = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'documentSid' => Values::array_get($payload, 'document_sid'), 'identity' => Values::array_get($payload, 'identity'), 'read' => Values::array_get($payload, 'read'), 'write' => Values::array_get($payload, 'write'), 'manage' => Values::array_get($payload, 'manage'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['serviceSid' => $serviceSid, 'documentSid' => $documentSid, 'identity' => $identity ?: $this->properties['identity'],];
    }

    protected function proxy(): DocumentPermissionContext
    {
        if (!$this->context) {
            $this->context = new DocumentPermissionContext($this->version, $this->solution['serviceSid'], $this->solution['documentSid'], $this->solution['identity']);
        }
        return $this->context;
    }

    public function fetch(): DocumentPermissionInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(bool $read, bool $write, bool $manage): DocumentPermissionInstance
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
        return '[Twilio.Sync.V1.DocumentPermissionInstance ' . implode(' ', $context) . ']';
    }
}