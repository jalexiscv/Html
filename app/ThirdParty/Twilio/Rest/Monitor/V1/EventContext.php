<?php

namespace Twilio\Rest\Monitor\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class EventContext extends InstanceContext
{
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Events/' . rawurlencode($sid) . '';
    }

    public function fetch(): EventInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new EventInstance($this->version, $payload, $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Monitor.V1.EventContext ' . implode(' ', $context) . ']';
    }
}