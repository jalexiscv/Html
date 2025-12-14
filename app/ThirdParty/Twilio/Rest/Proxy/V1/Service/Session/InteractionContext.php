<?php

namespace Twilio\Rest\Proxy\V1\Service\Session;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class InteractionContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $sessionSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sessionSid' => $sessionSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Sessions/' . rawurlencode($sessionSid) . '/Interactions/' . rawurlencode($sid) . '';
    }

    public function fetch(): InteractionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new InteractionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sessionSid'], $this->solution['sid']);
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
        return '[Twilio.Proxy.V1.InteractionContext ' . implode(' ', $context) . ']';
    }
}