<?php

namespace Twilio\Rest\Api\V2010\Account\Call;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class NotificationContext extends InstanceContext
{
    public function __construct(Version $version, $accountSid, $callSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'callSid' => $callSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Calls/' . rawurlencode($callSid) . '/Notifications/' . rawurlencode($sid) . '.json';
    }

    public function fetch(): NotificationInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new NotificationInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['callSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.NotificationContext ' . implode(' ', $context) . ']';
    }
}