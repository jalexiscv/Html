<?php

namespace Twilio\Rest\Autopilot\V1\Assistant;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class DefaultsContext extends InstanceContext
{
    public function __construct(Version $version, $assistantSid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/Defaults';
    }

    public function fetch(): DefaultsInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new DefaultsInstance($this->version, $payload, $this->solution['assistantSid']);
    }

    public function update(array $options = []): DefaultsInstance
    {
        $options = new Values($options);
        $data = Values::of(['Defaults' => Serialize::jsonObject($options['defaults']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new DefaultsInstance($this->version, $payload, $this->solution['assistantSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Autopilot.V1.DefaultsContext ' . implode(' ', $context) . ']';
    }
}