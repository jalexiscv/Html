<?php

namespace Twilio\Rest\Sync\V1\Service\Document;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class DocumentPermissionContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $documentSid, $identity)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'documentSid' => $documentSid, 'identity' => $identity,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Documents/' . rawurlencode($documentSid) . '/Permissions/' . rawurlencode($identity) . '';
    }

    public function fetch(): DocumentPermissionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new DocumentPermissionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['documentSid'], $this->solution['identity']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(bool $read, bool $write, bool $manage): DocumentPermissionInstance
    {
        $data = Values::of(['Read' => Serialize::booleanToString($read), 'Write' => Serialize::booleanToString($write), 'Manage' => Serialize::booleanToString($manage),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new DocumentPermissionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['documentSid'], $this->solution['identity']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Sync.V1.DocumentPermissionContext ' . implode(' ', $context) . ']';
    }
}