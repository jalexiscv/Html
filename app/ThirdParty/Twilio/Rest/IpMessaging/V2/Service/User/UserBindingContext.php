<?php

namespace Twilio\Rest\IpMessaging\V2\Service\User;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class UserBindingContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $userSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'userSid' => $userSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Users/' . rawurlencode($userSid) . '/Bindings/' . rawurlencode($sid) . '';
    }

    public function fetch(): UserBindingInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new UserBindingInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['userSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.IpMessaging.V2.UserBindingContext ' . implode(' ', $context) . ']';
    }
}