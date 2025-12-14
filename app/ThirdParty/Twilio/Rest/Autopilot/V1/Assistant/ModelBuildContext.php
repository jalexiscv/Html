<?php

namespace Twilio\Rest\Autopilot\V1\Assistant;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class ModelBuildContext extends InstanceContext
{
    public function __construct(Version $version, $assistantSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid, 'sid' => $sid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/ModelBuilds/' . rawurlencode($sid) . '';
    }

    public function fetch(): ModelBuildInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ModelBuildInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['sid']);
    }

    public function update(array $options = []): ModelBuildInstance
    {
        $options = new Values($options);
        $data = Values::of(['UniqueName' => $options['uniqueName'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ModelBuildInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['sid']);
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
        return '[Twilio.Autopilot.V1.ModelBuildContext ' . implode(' ', $context) . ']';
    }
}