<?php

namespace Twilio\Rest\Preview\Sync\Service\SyncMap;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class SyncMapPermissionContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $mapSid, $identity)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'mapSid' => $mapSid, 'identity' => $identity,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Maps/' . rawurlencode($mapSid) . '/Permissions/' . rawurlencode($identity) . '';
    }

    public function fetch(): SyncMapPermissionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SyncMapPermissionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['mapSid'], $this->solution['identity']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(bool $read, bool $write, bool $manage): SyncMapPermissionInstance
    {
        $data = Values::of(['Read' => Serialize::booleanToString($read), 'Write' => Serialize::booleanToString($write), 'Manage' => Serialize::booleanToString($manage),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new SyncMapPermissionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['mapSid'], $this->solution['identity']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.Sync.SyncMapPermissionContext ' . implode(' ', $context) . ']';
    }
}