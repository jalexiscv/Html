<?php

namespace Twilio\Rest\Preview\Understand\Assistant;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class QueryContext extends InstanceContext
{
    public function __construct(Version $version, $assistantSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid, 'sid' => $sid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/Queries/' . rawurlencode($sid) . '';
    }

    public function fetch(): QueryInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new QueryInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['sid']);
    }

    public function update(array $options = []): QueryInstance
    {
        $options = new Values($options);
        $data = Values::of(['SampleSid' => $options['sampleSid'], 'Status' => $options['status'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new QueryInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['sid']);
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
        return '[Twilio.Preview.Understand.QueryContext ' . implode(' ', $context) . ']';
    }
}