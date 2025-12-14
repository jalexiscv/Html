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

class StyleSheetContext extends InstanceContext
{
    public function __construct(Version $version, $assistantSid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/StyleSheet';
    }

    public function fetch(): StyleSheetInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new StyleSheetInstance($this->version, $payload, $this->solution['assistantSid']);
    }

    public function update(array $options = []): StyleSheetInstance
    {
        $options = new Values($options);
        $data = Values::of(['StyleSheet' => Serialize::jsonObject($options['styleSheet']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new StyleSheetInstance($this->version, $payload, $this->solution['assistantSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Autopilot.V1.StyleSheetContext ' . implode(' ', $context) . ']';
    }
}