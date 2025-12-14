<?php

namespace Twilio\Rest\Preview\Understand\Assistant\Task;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class FieldInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $assistantSid, string $taskSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'fieldType' => Values::array_get($payload, 'field_type'), 'taskSid' => Values::array_get($payload, 'task_sid'), 'assistantSid' => Values::array_get($payload, 'assistant_sid'), 'sid' => Values::array_get($payload, 'sid'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['assistantSid' => $assistantSid, 'taskSid' => $taskSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): FieldContext
    {
        if (!$this->context) {
            $this->context = new FieldContext($this->version, $this->solution['assistantSid'], $this->solution['taskSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): FieldInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
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
        return '[Twilio.Preview.Understand.FieldInstance ' . implode(' ', $context) . ']';
    }
}