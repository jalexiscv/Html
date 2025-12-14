<?php

namespace Twilio\Rest\Autopilot\V1\Assistant;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Autopilot\V1\Assistant\Task\FieldContext;
use Twilio\Rest\Autopilot\V1\Assistant\Task\FieldList;
use Twilio\Rest\Autopilot\V1\Assistant\Task\SampleContext;
use Twilio\Rest\Autopilot\V1\Assistant\Task\SampleList;
use Twilio\Rest\Autopilot\V1\Assistant\Task\TaskActionsContext;
use Twilio\Rest\Autopilot\V1\Assistant\Task\TaskActionsList;
use Twilio\Rest\Autopilot\V1\Assistant\Task\TaskStatisticsContext;
use Twilio\Rest\Autopilot\V1\Assistant\Task\TaskStatisticsList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class TaskContext extends InstanceContext
{
    protected $_fields;
    protected $_samples;
    protected $_taskActions;
    protected $_statistics;

    public function __construct(Version $version, $assistantSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid, 'sid' => $sid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/Tasks/' . rawurlencode($sid) . '';
    }

    public function fetch(): TaskInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new TaskInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['sid']);
    }

    public function update(array $options = []): TaskInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'UniqueName' => $options['uniqueName'], 'Actions' => Serialize::jsonObject($options['actions']), 'ActionsUrl' => $options['actionsUrl'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new TaskInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getFields(): FieldList
    {
        if (!$this->_fields) {
            $this->_fields = new FieldList($this->version, $this->solution['assistantSid'], $this->solution['sid']);
        }
        return $this->_fields;
    }

    protected function getSamples(): SampleList
    {
        if (!$this->_samples) {
            $this->_samples = new SampleList($this->version, $this->solution['assistantSid'], $this->solution['sid']);
        }
        return $this->_samples;
    }

    protected function getTaskActions(): TaskActionsList
    {
        if (!$this->_taskActions) {
            $this->_taskActions = new TaskActionsList($this->version, $this->solution['assistantSid'], $this->solution['sid']);
        }
        return $this->_taskActions;
    }

    protected function getStatistics(): TaskStatisticsList
    {
        if (!$this->_statistics) {
            $this->_statistics = new TaskStatisticsList($this->version, $this->solution['assistantSid'], $this->solution['sid']);
        }
        return $this->_statistics;
    }

    public function __get(string $name): ListResource
    {
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown subresource ' . $name);
    }

    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }
        throw new TwilioException('Resource does not have a context');
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Autopilot.V1.TaskContext ' . implode(' ', $context) . ']';
    }
}