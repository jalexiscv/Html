<?php

namespace Twilio\Rest\Api\V2010\Account\Message;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class MediaContext extends InstanceContext
{
    public function __construct(Version $version, $accountSid, $messageSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'messageSid' => $messageSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Messages/' . rawurlencode($messageSid) . '/Media/' . rawurlencode($sid) . '.json';
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function fetch(): MediaInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new MediaInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['messageSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.MediaContext ' . implode(' ', $context) . ']';
    }
}