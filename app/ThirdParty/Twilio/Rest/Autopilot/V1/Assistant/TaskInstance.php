<?php

namespace Twilio\Rest\Autopilot\V1\Assistant;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Autopilot\V1\Assistant\Task\FieldList;
use Twilio\Rest\Autopilot\V1\Assistant\Task\SampleList;
use Twilio\Rest\Autopilot\V1\Assistant\Task\TaskActionsList;
use Twilio\Rest\Autopilot\V1\Assistant\Task\TaskStatisticsList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class TaskInstance extends InstanceResource
{
    protected $_fields;
    protected $_samples;
    protected $_taskActions;
    protected $_statistics;

    public function __construct(Version $version, array $payload, string $assistantSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'links' => Values::array_get($payload, 'links'), 'assistantSid' => Values::array_get($payload, 'assistant_sid'), 'sid' => Values::array_get($payload, 'sid'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'actionsUrl' => Values::array_get($payload, 'actions_url'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['assistantSid' => $assistantSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): TaskContext
    {
        if (!$this->context) {
            $this->context = new TaskContext($this->version, $this->solution['assistantSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): TaskInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): TaskInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getFields(): FieldList
    {
        return $this->proxy()->fields;
    }

    protected function getSamples(): SampleList
    {
        return $this->proxy()->samples;
    }

    protected function getTaskActions(): TaskActionsList
    {
        return $this->proxy()->taskActions;
    }

    protected function getStatistics(): TaskStatisticsList
    {
        return $this->proxy()->statistics;
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
        return '[Twilio.Autopilot.V1.TaskInstance ' . implode(' ', $context) . ']';
    }
}