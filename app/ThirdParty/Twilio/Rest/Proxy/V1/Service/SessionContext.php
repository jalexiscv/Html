<?php

namespace Twilio\Rest\Proxy\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Proxy\V1\Service\Session\InteractionContext;
use Twilio\Rest\Proxy\V1\Service\Session\InteractionList;
use Twilio\Rest\Proxy\V1\Service\Session\ParticipantContext;
use Twilio\Rest\Proxy\V1\Service\Session\ParticipantList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class SessionContext extends InstanceContext
{
    protected $_interactions;
    protected $_participants;

    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Sessions/' . rawurlencode($sid) . '';
    }

    public function fetch(): SessionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SessionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(array $options = []): SessionInstance
    {
        $options = new Values($options);
        $data = Values::of(['DateExpiry' => Serialize::iso8601DateTime($options['dateExpiry']), 'Ttl' => $options['ttl'], 'Status' => $options['status'], 'FailOnParticipantConflict' => Serialize::booleanToString($options['failOnParticipantConflict']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new SessionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    protected function getInteractions(): InteractionList
    {
        if (!$this->_interactions) {
            $this->_interactions = new InteractionList($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->_interactions;
    }

    protected function getParticipants(): ParticipantList
    {
        if (!$this->_participants) {
            $this->_participants = new ParticipantList($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->_participants;
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
        return '[Twilio.Proxy.V1.SessionContext ' . implode(' ', $context) . ']';
    }
}