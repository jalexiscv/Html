<?php

namespace Twilio\Rest\Conversations\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class RoleContext extends InstanceContext
{
    public function __construct(Version $version, $chatServiceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['chatServiceSid' => $chatServiceSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($chatServiceSid) . '/Roles/' . rawurlencode($sid) . '';
    }

    public function update(array $permission): RoleInstance
    {
        $data = Values::of(['Permission' => Serialize::map($permission, function ($e) {
            return $e;
        }),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new RoleInstance($this->version, $payload, $this->solution['chatServiceSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function fetch(): RoleInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new RoleInstance($this->version, $payload, $this->solution['chatServiceSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Conversations.V1.RoleContext ' . implode(' ', $context) . ']';
    }
}