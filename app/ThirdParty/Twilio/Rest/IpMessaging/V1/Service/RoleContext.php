<?php

namespace Twilio\Rest\IpMessaging\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class RoleContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Roles/' . rawurlencode($sid) . '';
    }

    public function fetch(): RoleInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new RoleInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(array $permission): RoleInstance
    {
        $data = Values::of(['Permission' => Serialize::map($permission, function ($e) {
            return $e;
        }),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new RoleInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.IpMessaging.V1.RoleContext ' . implode(' ', $context) . ']';
    }
}