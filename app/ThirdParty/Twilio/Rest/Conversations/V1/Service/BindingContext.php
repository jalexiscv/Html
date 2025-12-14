<?php

namespace Twilio\Rest\Conversations\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class BindingContext extends InstanceContext
{
    public function __construct(Version $version, $chatServiceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['chatServiceSid' => $chatServiceSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($chatServiceSid) . '/Bindings/' . rawurlencode($sid) . '';
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function fetch(): BindingInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new BindingInstance($this->version, $payload, $this->solution['chatServiceSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Conversations.V1.BindingContext ' . implode(' ', $context) . ']';
    }
}