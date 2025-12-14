<?php

namespace Twilio\Rest\Preview\Understand;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Preview\Understand\Assistant\AssistantFallbackActionsContext;
use Twilio\Rest\Preview\Understand\Assistant\AssistantFallbackActionsList;
use Twilio\Rest\Preview\Understand\Assistant\AssistantInitiationActionsContext;
use Twilio\Rest\Preview\Understand\Assistant\AssistantInitiationActionsList;
use Twilio\Rest\Preview\Understand\Assistant\DialogueContext;
use Twilio\Rest\Preview\Understand\Assistant\DialogueList;
use Twilio\Rest\Preview\Understand\Assistant\FieldTypeContext;
use Twilio\Rest\Preview\Understand\Assistant\FieldTypeList;
use Twilio\Rest\Preview\Understand\Assistant\ModelBuildContext;
use Twilio\Rest\Preview\Understand\Assistant\ModelBuildList;
use Twilio\Rest\Preview\Understand\Assistant\QueryContext;
use Twilio\Rest\Preview\Understand\Assistant\QueryList;
use Twilio\Rest\Preview\Understand\Assistant\StyleSheetContext;
use Twilio\Rest\Preview\Understand\Assistant\StyleSheetList;
use Twilio\Rest\Preview\Understand\Assistant\TaskContext;
use Twilio\Rest\Preview\Understand\Assistant\TaskList;
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
    protected $_assistantFallbackActions;
    protected $_assistantInitiationActions;
    protected $_dialogues;
    protected $_styleSheet;

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
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'LogQueries' => Serialize::booleanToString($options['logQueries']), 'UniqueName' => $options['uniqueName'], 'CallbackUrl' => $options['callbackUrl'], 'CallbackEvents' => $options['callbackEvents'], 'FallbackActions' => Serialize::jsonObject($options['fallbackActions']), 'InitiationActions' => Serialize::jsonObject($options['initiationActions']), 'StyleSheet' => Serialize::jsonObject($options['styleSheet']),]);
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

    protected function getAssistantFallbackActions(): AssistantFallbackActionsList
    {
        if (!$this->_assistantFallbackActions) {
            $this->_assistantFallbackActions = new AssistantFallbackActionsList($this->version, $this->solution['sid']);
        }
        return $this->_assistantFallbackActions;
    }

    protected function getAssistantInitiationActions(): AssistantInitiationActionsList
    {
        if (!$this->_assistantInitiationActions) {
            $this->_assistantInitiationActions = new AssistantInitiationActionsList($this->version, $this->solution['sid']);
        }
        return $this->_assistantInitiationActions;
    }

    protected function getDialogues(): DialogueList
    {
        if (!$this->_dialogues) {
            $this->_dialogues = new DialogueList($this->version, $this->solution['sid']);
        }
        return $this->_dialogues;
    }

    protected function getStyleSheet(): StyleSheetList
    {
        if (!$this->_styleSheet) {
            $this->_styleSheet = new StyleSheetList($this->version, $this->solution['sid']);
        }
        return $this->_styleSheet;
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
        return '[Twilio.Preview.Understand.AssistantContext ' . implode(' ', $context) . ']';
    }
}