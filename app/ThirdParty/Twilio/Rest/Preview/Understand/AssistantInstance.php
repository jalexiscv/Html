<?php

namespace Twilio\Rest\Preview\Understand;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Preview\Understand\Assistant\AssistantFallbackActionsList;
use Twilio\Rest\Preview\Understand\Assistant\AssistantInitiationActionsList;
use Twilio\Rest\Preview\Understand\Assistant\DialogueList;
use Twilio\Rest\Preview\Understand\Assistant\FieldTypeList;
use Twilio\Rest\Preview\Understand\Assistant\ModelBuildList;
use Twilio\Rest\Preview\Understand\Assistant\QueryList;
use Twilio\Rest\Preview\Understand\Assistant\StyleSheetList;
use Twilio\Rest\Preview\Understand\Assistant\TaskList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class AssistantInstance extends InstanceResource
{
    protected $_fieldTypes;
    protected $_tasks;
    protected $_modelBuilds;
    protected $_queries;
    protected $_assistantFallbackActions;
    protected $_assistantInitiationActions;
    protected $_dialogues;
    protected $_styleSheet;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'latestModelBuildSid' => Values::array_get($payload, 'latest_model_build_sid'), 'links' => Values::array_get($payload, 'links'), 'logQueries' => Values::array_get($payload, 'log_queries'), 'sid' => Values::array_get($payload, 'sid'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'url' => Values::array_get($payload, 'url'), 'callbackUrl' => Values::array_get($payload, 'callback_url'), 'callbackEvents' => Values::array_get($payload, 'callback_events'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): AssistantContext
    {
        if (!$this->context) {
            $this->context = new AssistantContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): AssistantInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): AssistantInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getFieldTypes(): FieldTypeList
    {
        return $this->proxy()->fieldTypes;
    }

    protected function getTasks(): TaskList
    {
        return $this->proxy()->tasks;
    }

    protected function getModelBuilds(): ModelBuildList
    {
        return $this->proxy()->modelBuilds;
    }

    protected function getQueries(): QueryList
    {
        return $this->proxy()->queries;
    }

    protected function getAssistantFallbackActions(): AssistantFallbackActionsList
    {
        return $this->proxy()->assistantFallbackActions;
    }

    protected function getAssistantInitiationActions(): AssistantInitiationActionsList
    {
        return $this->proxy()->assistantInitiationActions;
    }

    protected function getDialogues(): DialogueList
    {
        return $this->proxy()->dialogues;
    }

    protected function getStyleSheet(): StyleSheetList
    {
        return $this->proxy()->styleSheet;
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
        return '[Twilio.Preview.Understand.AssistantInstance ' . implode(' ', $context) . ']';
    }
}