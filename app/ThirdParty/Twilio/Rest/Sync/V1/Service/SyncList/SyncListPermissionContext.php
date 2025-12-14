<?php

namespace Twilio\Rest\Sync\V1\Service\SyncList;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class SyncListPermissionContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $listSid, $identity)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'listSid' => $listSid, 'identity' => $identity,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Lists/' . rawurlencode($listSid) . '/Permissions/' . rawurlencode($identity) . '';
    }

    public function fetch(): SyncListPermissionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SyncListPermissionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['listSid'], $this->solution['identity']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(bool $read, bool $write, bool $manage): SyncListPermissionInstance
    {
        $data = Values::of(['Read' => Serialize::booleanToString($read), 'Write' => Serialize::booleanToString($write), 'Manage' => Serialize::booleanToString($manage),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new SyncListPermissionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['listSid'], $this->solution['identity']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Sync.V1.SyncListPermissionContext ' . implode(' ', $context) . ']';
    }
}