<?php

namespace Twilio\Rest\Autopilot\V1\Assistant\Task;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class SampleContext extends InstanceContext
{
    public function __construct(Version $version, $assistantSid, $taskSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid, 'taskSid' => $taskSid, 'sid' => $sid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/Tasks/' . rawurlencode($taskSid) . '/Samples/' . rawurlencode($sid) . '';
    }

    public function fetch(): SampleInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SampleInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['taskSid'], $this->solution['sid']);
    }

    public function update(array $options = []): SampleInstance
    {
        $options = new Values($options);
        $data = Values::of(['Language' => $options['language'], 'TaggedText' => $options['taggedText'], 'SourceChannel' => $options['sourceChannel'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new SampleInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['taskSid'], $this->solution['sid']);
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
        return '[Twilio.Autopilot.V1.SampleContext ' . implode(' ', $context) . ']';
    }
}