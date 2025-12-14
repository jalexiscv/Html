<?php

namespace Twilio\Rest\Autopilot\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Autopilot\V1\Assistant\DefaultsContext;
use Twilio\Rest\Autopilot\V1\Assistant\DefaultsList;
use Twilio\Rest\Autopilot\V1\Assistant\DialogueContext;
use Twilio\Rest\Autopilot\V1\Assistant\DialogueList;
use Twilio\Rest\Autopilot\V1\Assistant\FieldTypeContext;
use Twilio\Rest\Autopilot\V1\Assistant\FieldTypeList;
use Twilio\Rest\Autopilot\V1\Assistant\ModelBuildContext;
use Twilio\Rest\Autopilot\V1\Assistant\ModelBuildList;
use Twilio\Rest\Autopilot\V1\Assistant\QueryContext;
use Twilio\Rest\Autopilot\V1\Assistant\QueryList;
use Twilio\Rest\Autopilot\V1\Assistant\StyleSheetContext;
use Twilio\Rest\Autopilot\V1\Assistant\StyleSheetList;
use Twilio\Rest\Autopilot\V1\Assistant\TaskContext;
use Twilio\Rest\Autopilot\V1\Assistant\TaskList;
use Twilio\Rest\Autopilot\V1\Assistant\WebhookContext;
use Twilio\Rest\Autopilot\V1\Assistant\WebhookList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class AssistantContext extends InstanceContext
{
    protected $_fieldTypes;
    protected $_tasks;
    protected $_modelBuilds;
    protected $_queries;
    protected $_styleSheet;
    protected $_defaults;
    protected $_dialogues;
    protected $_webhooks;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Assistants/' . rawurlencode($sid) . '';
    }

    public function fetch(): AssistantInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new AssistantInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): AssistantInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'LogQueries' => Serialize::booleanToString($options['logQueries']), 'UniqueName' => $options['uniqueName'], 'CallbackUrl' => $options['callbackUrl'], 'CallbackEvents' => $options['callbackEvents'], 'StyleSheet' => Serialize::jsonObject($options['styleSheet']), 'Defaults' => Serialize::jsonObject($options['defaults']), 'DevelopmentStage' => $options['developmentStage'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new AssistantInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getFieldTypes(): FieldTypeList
    {
        if (!$this->_fieldTypes) {
            $this->_fieldTypes = new FieldTypeList($this->version, $this->solution['sid']);
        }
        return $this->_fieldTypes;
    }

    protected function getTasks(): TaskList
    {
        if (!$this->_tasks) {
            $this->_tasks = new TaskList($this->version, $this->solution['sid']);
        }
        return $this->_tasks;
    }

    protected function getModelBuilds(): ModelBuildList
    {
        if (!$this->_modelBuilds) {
            $this->_modelBuilds = new ModelBuildList($this->version, $this->solution['sid']);
        }
        return $this->_modelBuilds;
    }

    protected function getQueries(): QueryList
    {
        if (!$this->_queries) {
            $this->_queries = new QueryList($this->version, $this->solution['sid']);
        }
        return $this->_queries;
    }

    protected function getStyleSheet(): StyleSheetList
    {
        if (!$this->_styleSheet) {
            $this->_styleSheet = new StyleSheetList($this->version, $this->solution['sid']);
        }
        return $this->_styleSheet;
    }

    protected function getDefaults(): DefaultsList
    {
        if (!$this->_defaults) {
            $this->_defaults = new DefaultsList($this->version, $this->solution['sid']);
        }
        return $this->_defaults;
    }

    protected function getDialogues(): DialogueList
    {
        if (!$this->_dialogues) {
            $this->_dialogues = new DialogueList($this->version, $this->solution['sid']);
        }
        return $this->_dialogues;
    }

    protected function getWebhooks(): WebhookList
    {
        if (!$this->_webhooks) {
            $this->_webhooks = new WebhookList($this->version, $this->solution['sid']);
        }
        return $this->_webhooks;
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
        return '[Twilio.Autopilot.V1.AssistantContext ' . implode(' ', $context) . ']';
    }
}