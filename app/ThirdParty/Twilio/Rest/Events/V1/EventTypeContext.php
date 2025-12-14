<?php

namespace Twilio\Rest\Events\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class EventTypeContext extends InstanceContext
{
    public function __construct(Version $version, $type)
    {
        parent::__construct($version);
        $this->solution = ['type' => $type,];
        $this->uri = '/Types/' . rawurlencode($type) . '';
    }

    public function fetch(): EventTypeInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new EventTypeInstance($this->version, $payload, $this->solution['type']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Events.V1.EventTypeContext ' . implode(' ', $context) . ']';
    }
}