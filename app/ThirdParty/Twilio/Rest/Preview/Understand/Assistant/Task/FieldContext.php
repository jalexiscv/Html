<?php

namespace Twilio\Rest\Preview\Understand\Assistant\Task;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class FieldContext extends InstanceContext
{
    public function __construct(Version $version, $assistantSid, $taskSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid, 'taskSid' => $taskSid, 'sid' => $sid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/Tasks/' . rawurlencode($taskSid) . '/Fields/' . rawurlencode($sid) . '';
    }

    public function fetch(): FieldInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new FieldInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['taskSid'], $this->solution['sid']);
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
        return '[Twilio.Preview.Understand.FieldContext ' . implode(' ', $context) . ']';
    }
}