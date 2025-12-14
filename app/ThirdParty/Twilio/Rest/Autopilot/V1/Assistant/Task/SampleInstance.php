<?php

namespace Twilio\Rest\Autopilot\V1\Assistant\Task;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class SampleInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $assistantSid, string $taskSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'taskSid' => Values::array_get($payload, 'task_sid'), 'language' => Values::array_get($payload, 'language'), 'assistantSid' => Values::array_get($payload, 'assistant_sid'), 'sid' => Values::array_get($payload, 'sid'), 'taggedText' => Values::array_get($payload, 'tagged_text'), 'url' => Values::array_get($payload, 'url'), 'sourceChannel' => Values::array_get($payload, 'source_channel'),];
        $this->solution = ['assistantSid' => $assistantSid, 'taskSid' => $taskSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): SampleContext
    {
        if (!$this->context) {
            $this->context = new SampleContext($this->version, $this->solution['assistantSid'], $this->solution['taskSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): SampleInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): SampleInstance
    {
        return $this->proxy()->update($options);
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
        return '[Twilio.Autopilot.V1.SampleInstance ' . implode(' ', $context) . ']';
    }
}