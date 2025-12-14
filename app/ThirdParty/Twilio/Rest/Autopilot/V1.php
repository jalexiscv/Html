<?php

namespace Twilio\Rest\Autopilot;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Autopilot\V1\AssistantContext;
use Twilio\Rest\Autopilot\V1\AssistantList;
use Twilio\Rest\Autopilot\V1\RestoreAssistantList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class V1 extends Version
{
    protected $_assistants;
    protected $_restoreAssistant;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'v1';
    }

    protected function getAssistants(): AssistantList
    {
        if (!$this->_assistants) {
            $this->_assistants = new AssistantList($this);
        }
        return $this->_assistants;
    }

    protected function getRestoreAssistant(): RestoreAssistantList
    {
        if (!$this->_restoreAssistant) {
            $this->_restoreAssistant = new RestoreAssistantList($this);
        }
        return $this->_restoreAssistant;
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new TwilioException('Unknown resource ' . $name);
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
        return '[Twilio.Autopilot.V1]';
    }
}