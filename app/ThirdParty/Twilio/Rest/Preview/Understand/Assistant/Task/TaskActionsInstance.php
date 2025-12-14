<?php

namespace Twilio\Rest\Preview\Understand\Assistant\Task;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class TaskActionsInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $assistantSid, string $taskSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'assistantSid' => Values::array_get($payload, 'assistant_sid'), 'taskSid' => Values::array_get($payload, 'task_sid'), 'url' => Values::array_get($payload, 'url'), 'data' => Values::array_get($payload, 'data'),];
        $this->solution = ['assistantSid' => $assistantSid, 'taskSid' => $taskSid,];
    }

    protected function proxy(): TaskActionsContext
    {
        if (!$this->context) {
            $this->context = new TaskActionsContext($this->version, $this->solution['assistantSid'], $this->solution['taskSid']);
        }
        return $this->context;
    }

    public function fetch(): TaskActionsInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): TaskActionsInstance
    {
        return $this->proxy()->update($options);
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown property: ' . $name);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.Understand.TaskActionsInstance ' . implode(' ', $context) . ']';
    }
}