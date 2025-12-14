<?php

namespace Twilio\Rest\Proxy\V1\Service\Session;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Proxy\V1\Service\Session\Participant\MessageInteractionContext;
use Twilio\Rest\Proxy\V1\Service\Session\Participant\MessageInteractionList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class ParticipantContext extends InstanceContext
{
    protected $_messageInteractions;

    public function __construct(Version $version, $serviceSid, $sessionSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sessionSid' => $sessionSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Sessions/' . rawurlencode($sessionSid) . '/Participants/' . rawurlencode($sid) . '';
    }

    public function fetch(): ParticipantInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ParticipantInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sessionSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getMessageInteractions(): MessageInteractionList
    {
        if (!$this->_messageInteractions) {
            $this->_messageInteractions = new MessageInteractionList($this->version, $this->solution['serviceSid'], $this->solution['sessionSid'], $this->solution['sid']);
        }
        return $this->_messageInteractions;
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
        return '[Twilio.Proxy.V1.ParticipantContext ' . implode(' ', $context) . ']';
    }
}