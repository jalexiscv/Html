<?php

namespace Twilio\Rest\Preview\Understand\Assistant\Task;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class TaskActionsContext extends InstanceContext
{
    public function __construct(Version $version, $assistantSid, $taskSid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid, 'taskSid' => $taskSid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/Tasks/' . rawurlencode($taskSid) . '/Actions';
    }

    public function fetch(): TaskActionsInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new TaskActionsInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['taskSid']);
    }

    public function update(array $options = []): TaskActionsInstance
    {
        $options = new Values($options);
        $data = Values::of(['Actions' => Serialize::jsonObject($options['actions']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new TaskActionsInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['taskSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.Understand.TaskActionsContext ' . implode(' ', $context) . ']';
    }
}