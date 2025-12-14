<?php

namespace Twilio\Rest\Preview\Understand\Assistant\Task;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class TaskStatisticsInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $assistantSid, string $taskSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'assistantSid' => Values::array_get($payload, 'assistant_sid'), 'taskSid' => Values::array_get($payload, 'task_sid'), 'samplesCount' => Values::array_get($payload, 'samples_count'), 'fieldsCount' => Values::array_get($payload, 'fields_count'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['assistantSid' => $assistantSid, 'taskSid' => $taskSid,];
    }

    protected function proxy(): TaskStatisticsContext
    {
        if (!$this->context) {
            $this->context = new TaskStatisticsContext($this->version, $this->solution['assistantSid'], $this->solution['taskSid']);
        }
        return $this->context;
    }

    public function fetch(): TaskStatisticsInstance
    {
        return $this->proxy()->fetch();
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
        return '[Twilio.Preview.Understand.TaskStatisticsInstance ' . implode(' ', $context) . ']';
    }
}