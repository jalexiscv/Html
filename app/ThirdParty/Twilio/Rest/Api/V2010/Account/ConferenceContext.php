<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Api\V2010\Account\Conference\ParticipantContext;
use Twilio\Rest\Api\V2010\Account\Conference\ParticipantList;
use Twilio\Rest\Api\V2010\Account\Conference\RecordingList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class ConferenceContext extends InstanceContext
{
    protected $_participants;
    protected $_recordings;

    public function __construct(Version $version, $accountSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Conferences/' . rawurlencode($sid) . '.json';
    }

    public function fetch(): ConferenceInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ConferenceInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    public function update(array $options = []): ConferenceInstance
    {
        $options = new Values($options);
        $data = Values::of(['Status' => $options['status'], 'AnnounceUrl' => $options['announceUrl'], 'AnnounceMethod' => $options['announceMethod'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ConferenceInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    protected function getParticipants(): ParticipantList
    {
        if (!$this->_participants) {
            $this->_participants = new ParticipantList($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->_participants;
    }

    protected function getRecordings(): RecordingList
    {
        if (!$this->_recordings) {
            $this->_recordings = new RecordingList($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->_recordings;
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
        return '[Twilio.Api.V2010.ConferenceContext ' . implode(' ', $context) . ']';
    }
}